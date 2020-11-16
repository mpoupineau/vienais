<?php
namespace App\Manager;

use App\Entity\Bottle;
use App\Entity\DeliveryFees;
use App\Entity\Order;
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


    public function add(array $bottles, $address)
    {
        $order = new Order();
        $rawBottles = "";
        $subPrice = $this->calculateSubPrice($bottles);
        $deliveryFees = $this->calculateDeliveryFees($bottles);

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
        $order->setPrice($this->calculateTotalPrice($deliveryFees, $subPrice));
        $order->setRaw($rawBottles);
        $order->setDeliveryAddress($address);

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

    public function calculateTotalPrice($deliveryFees, $subPrice)
    {
        return round($deliveryFees + $subPrice, 2);
    }

    public function delete(Bottle $bottle)
    {
        $this->entityManager->remove($bottle);
        $this->entityManager->flush();
    }

    public function setPaymentType(Order $order, $paymentType)
    {
        if ("check" === $paymentType) {
            $order->setPaymentType(Order::PAYMENT_TYPE_CHECK);
            $order->setState(Order::STATE_WAITING_FOR_CHECK);
        } else {
            $order->setPaymentType(Order::PAYMENT_TYPE_CARD);
            $order->setState(Order::STATE_WAITING_FOR_CARD);
        }

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
}