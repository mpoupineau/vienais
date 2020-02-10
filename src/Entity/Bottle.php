<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bottle
 *
 * @ORM\Table(name="bottle", indexes={@ORM\Index(name="fk_foreign_capacity_id", columns={"capacity_id"}), @ORM\Index(name="fk_foreign_cuvee_id", columns={"cuvee_id"})})
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
     * @var int
     *
     * @ORM\Column(name="year", type="integer", nullable=false)
     */
    private $year;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Cuvee")
     * @ORM\JoinColumn(name="cuvee_id", referencedColumnName="id")
     */
    private $cuvee;

    /**
     * @var Capacity|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Capacity")
     * @ORM\JoinColumn(name="capacity_id", referencedColumnName="id")
     */
    private $capacity;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority = 0;

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
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     * @return Bottle
     */
    public function setYear($year)
    {
        $this->year = $year;
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Bottle
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return Cuvee|null
     */
    public function getCuvee()
    {
        return $this->cuvee;
    }

    /**
     * @param Cuvee|null $cuvee
     * @return Bottle
     */
    public function setCuvee($cuvee)
    {
        $this->cuvee = $cuvee;
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

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return Cuvee
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }
}
