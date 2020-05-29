<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bottle
 *
 * @ORM\Table(name="v_bottle", indexes={@ORM\Index(name="fk_foreign_capacity_id", columns={"capacity_id"}), @ORM\Index(name="fk_foreign_vintage_id", columns={"vintage_id"})})
 * @ORM\Entity
 */
class Bottle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean", nullable=false)
     */
    private $available = true;

    /**
     * @var Cuvee|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Vintage", inversedBy="bottles")
     * @ORM\JoinColumn(name="vintage_id", referencedColumnName="id")
     */
    private $vintage;

    /**
     * @var Capacity|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Capacity")
     * @ORM\JoinColumn(name="capacity_id", referencedColumnName="id")
     */
    private $capacity;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Bottle
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Bottle
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     * @return Bottle
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAvailable()
    {
        return $this->available;
    }

    /**
     * @param bool $available
     * @return Bottle
     */
    public function setAvailable($available)
    {
        $this->available = $available;
        return $this;
    }

    /**
     * @return Vintage|null
     */
    public function getVintage()
    {
        return $this->vintage;
    }

    /**
     * @param Vintage|null $cuvee
     * @return Bottle
     */
    public function setVintage($vintage)
    {
        $this->vintage = $vintage;
        return $this;
    }

    /**
     * @return Capacity|null
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param Capacity|null $capacity
     * @return Bottle
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
        return $this;
    }
}
