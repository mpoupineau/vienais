<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeliveryFees
 *
 * @ORM\Table(name="v_delivery_fees")
 * @ORM\Entity
 */
class DeliveryFees
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
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=30, nullable=true)
     */
    private $name;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="fees", type="float", precision=10, scale=0, nullable=true)
     */
    private $fees;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return DeliveryFees
     */
    public function setId(int $id): DeliveryFees
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return DeliveryFees
     */
    public function setName(?string $name): DeliveryFees
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     * @return DeliveryFees
     */
    public function setQuantity(?int $quantity): DeliveryFees
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getFees(): ?float
    {
        return $this->fees;
    }

    /**
     * @param float|null $fees
     * @return DeliveryFees
     */
    public function setFees(float $fees): DeliveryFees
    {
        $this->fees = $fees;
        return $this;
    }
}
