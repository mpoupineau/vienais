<?php
namespace App\Manager;

use App\Entity\Bottle;
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
        $subPrice = 0.0;

        foreach ($bottles as $bottleId => $quantity) {
            if (0 < $quantity) {
                /** @var Bottle $bottle */
                $bottle = $this->entityManager->getRepository(Bottle::class)->find($bottleId);
                if ($bottle->isAvailable()){
                    $rawBottles .= $bottle->getVintage()->getCuvee()->getName() . " " . $bottle->getVintage()->getYear() . " -  " . $bottle->getCapacity()->getName();
                    $rawBottles .= "|" . $quantity . "|" . $bottle->getPrice(). "|" . $bottle->getPromoPrice() . '/';
                    $subPrice += $quantity * $bottle->getPrice();
                }
            }
        }

        $order->setDeliveryFees(0.0);
        $order->setSubPrice($subPrice);
        $order->setPrice($subPrice);
        $order->setRaw($rawBottles);
        $order->setDeliveryAddress($address);

        $this->entityManager->persist($address);
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }

    public function delete(Bottle $bottle)
    {
        $this->entityManager->remove($bottle);
        $this->entityManager->flush();
    }
}