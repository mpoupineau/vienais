<?php
namespace App\Manager;

use App\Entity\Bottle;
use App\Entity\DeliveryFees;
use App\Entity\Order;
use App\Entity\PromoCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class OrderManager
{

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var ParameterBagInterface */
    private $parameterBag;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag)
    {
        $this->entityManager = $entityManager;
        $this->parameterBag = $parameterBag;
    }


    public function add(array $bottles, $address, $promoCodeId)
    {
        $order = new Order();
        $rawBottles = "";
        $subPrice = $this->calculateSubPrice($bottles);
        $deliveryFees = $this->calculateDeliveryFees($bottles);
        $totalDiscount = $this->calculateDiscount($promoCodeId, $deliveryFees);

        foreach ($bottles as $bottleId => $quantity) {
            if (0 < $quantity) {
                /** @var Bottle $bottle */
                $bottle = $this->entityManager->getRepository(Bottle::class)->find($bottleId);
                if ($bottle->isAvailable()){
                    $rawBottles .= $bottle->getVintage()->getCuvee()->getName() . " " . $bottle->getVintage()->getYear() . " -  " . $bottle->getCapacity()->getName();
                    $rawBottles .= "|" . $quantity . "|" . $bottle->getPrice(). "|" . $bottle->getPromoPrice() . '/';
                }
            }
        }

        $order->setDeliveryFees($deliveryFees);
        $order->setSubPrice($subPrice);
        $order->setPrice($this->calculateTotalPrice($deliveryFees, $subPrice, $totalDiscount));
        $order->setRaw($rawBottles);
        $order->setDeliveryAddress($address);

        if (0 < $totalDiscount) {
            $promoCode = $this->entityManager->getRepository(PromoCode::class)->find($promoCodeId);
            $order->setTotalDiscount($totalDiscount);
            $order->setDiscountId($promoCodeId);
            $order->setDiscountDescription($promoCode->getDescription());
        }

        $this->entityManager->persist($address);
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }

    public function calculateSubPrice($bottles)
    {
        $subPrice = 0.0;

        foreach ($bottles as $bottleId => $quantity) {
            if (0 < $quantity) {
                /** @var Bottle $bottle */
                $bottle = $this->entityManager->getRepository(Bottle::class)->find($bottleId);

                if ($bottle->isAvailable()){
                    if ($bottle->getPromoPrice()) {
                        $subPrice += $quantity * $bottle->getPromoPrice();
                    } else {
                        $subPrice += $quantity * $bottle->getPrice();
                    }
                }
            }
        }

        return round($subPrice, 2);
    }

    public function calculateDeliveryFees($bottles)
    {
        $totalVolume =  0;
        foreach ($bottles as $key => $value){
            if ("" !== $value) {
                /** @var Bottle $bottle */
                $bottle = $this->entityManager->getRepository(Bottle::class)->find($key);
                $volume = ceil($bottle->getCapacity()->getVolume());
                $totalVolume += $volume * $value;
            }
        }

        /** @var DeliveryFees[] $deliveryFeesList */
        $deliveryFeesList = $this->entityManager->getRepository(DeliveryFees::class)->findBy(
            [],
            [
                "quantity" => 'DESC'
            ]
        );

        foreach ($deliveryFeesList as $deliveryFees) {

            if ($deliveryFees->getQuantity() <= $totalVolume) {
                return round($totalVolume * $deliveryFees->getFees(), 2);
            }
        }
        return 0;
    }

    public function calculateDiscount($promoCodeSession, $deliveryFees)
    {
        if ("" !== $promoCodeSession) {
            /** @var PromoCode $promoCode */
            $promoCode = $this->entityManager->getRepository(PromoCode::class)->find($promoCodeSession);

            if ($promoCode && $promoCode->isValid()) {
                if (PromoCode::TYPE_FEES === $promoCode->getType()) {
                    if (null !== $promoCode->getVariableReduction()) {
                        return round($deliveryFees * $promoCode->getVariableReduction() / 100, 2);
                    }
                }
            }
        }

        return 0.0;
    }

    public function calculateTotalPrice($deliveryFees, $subPrice, $totalDiscount)
    {
        return round($deliveryFees + $subPrice - $totalDiscount, 2);
    }

    public function delete(Bottle $bottle)
    {
        $this->entityManager->remove($bottle);
        $this->entityManager->flush();
    }

    public function setPaymentType(Order $order, $paymentType)
    {
        if (Order::PAYMENT_TYPE_CHECK === $paymentType) {
            $order->setPaymentType(Order::PAYMENT_TYPE_CHECK);
            $order->setState(Order::STATE_WAITING_FOR_CHECK);
        } else {
            $order->setPaymentType(Order::PAYMENT_TYPE_CARD);
            $order->setState(Order::STATE_WAITING_FOR_CARD);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function mailSent(Order $order)
    {
        $order->setMailSent(true);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    /**
     * @param Order $order
     * @param $result
     * @throws \Exception
     */
    public function setPaymentResult(Order $order, $result)
    {
        if (Order::STATE_WAITING_FOR_CARD !== $order->getState()) {
            throw new \Exception('Invalid current state');
        }

        switch ($result) {
            case "success":
                $order->setState(Order::STATE_PAID);
                break;
            case "cancelled":
            default:
                $order->setState(Order::STATE_PAYMENT_CANCELED);
                break;
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function setTppReference(Order $order, $tppReference)
    {
        $order->setTppReference($tppReference);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}