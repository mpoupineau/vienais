<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bottle
 *
 * @ORM\Table(name="bottle", indexes={@ORM\Index(name="fk_foreign_wine_type_id", columns={"wine_type_id"}), @ORM\Index(name="fk_foreign_capacity_id", columns={"capacity_id"}), @ORM\Index(name="fk_foreign_cuvee_id", columns={"cuvee_id"})})
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
     * @ORM\Column(name="hidden", type="boolean", nullable=false)
     */
    private $hidden = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean", nullable=false)
     */
    private $available = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="cuvee_id", type="integer", nullable=true)
     */
    private $cuveeId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="wine_type_id", type="integer", nullable=true)
     */
    private $wineTypeId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="capacity_id", type="integer", nullable=true)
     */
    private $capacityId;

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
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     * @return Bottle
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
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


}
