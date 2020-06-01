<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Table(name="v_order")
 * @ORM\Entity
 */
class Order
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
     * @ORM\Column(name="raw", type="text", length=65535, nullable=false)
     */
    private $raw;

    private $basket;

    /**
     * @var float
     *
     * @ORM\Column(name="sub_price", type="float", precision=10, scale=0, nullable=false)
     */
    private $subPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="delivery_fees", type="float", precision=10, scale=0, nullable=false)
     */
    private $deliveryFees;


    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var DeliveryAddress|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\DeliveryAddress")
     * @ORM\JoinColumn(name="delivery_address_id", referencedColumnName="id")
     */
    private $deliveryAddress;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Order
     */
    public function setId(int $id): Order
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRaw(): ?string
    {
        return $this->raw;
    }

    /**
     * @param string|null $raw
     * @return Order
     */
    public function setRaw(?string $raw): Order
    {
        $this->raw = $raw;
        return $this;
    }

    /**
     * @return float
     */
    public function getSubPrice(): float
    {
        return $this->subPrice;
    }

    /**
     * @param float $subPrice
     * @return Order
     */
    public function setSubPrice(float $subPrice): Order
    {
        $this->subPrice = $subPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getDeliveryFees(): float
    {
        return $this->deliveryFees;
    }

    /**
     * @param float $deliveryFees
     * @return Order
     */
    public function setDeliveryFees(float $deliveryFees): Order
    {
        $this->deliveryFees = $deliveryFees;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Order
     */
    public function setPrice(float $price): Order
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Order
     */
    public function setCreatedAt(\DateTime $createdAt): Order
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DeliveryAddress|null
     */
    public function getDeliveryAddress(): ?DeliveryAddress
    {
        return $this->deliveryAddress;
    }

    /**
     * @param DeliveryAddress|null $deliveryAddress
     * @return Order
     */
    public function setDeliveryAddress(?DeliveryAddress $deliveryAddress): Order
    {
        $this->deliveryAddress = $deliveryAddress;
        return $this;
    }

    public function getBasket()
    {
        $products = explode("/", $this->raw);
        $basket = [];

        foreach ($products as $product) {
            $details = explode("|", $product);
            if (3 === count($details)) {
                $basket[] =
                    [
                        "name" => $details[0],
                        'quantity' => $details[1],
                        'price' => floatval($details[2])
                    ];
            }

        }

        return $basket;
    }



}
