<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * DeliveryFees
 *
 */
class DeliveryFeesGroup
{


    protected $deliveryFees;

    public function __construct()
    {
        $this->deliveryFees = new ArrayCollection();
    }

    public function getDeliveryFees()
    {
        return $this->deliveryFees;
    }

    public function setDeliveryFees($deliveryFees)
    {
        $this->deliveryFees = $deliveryFees;
    }

    public function addDeliveryFees($deliveryFees)
    {
        $this->deliveryFees->add($deliveryFees);
    }
}
