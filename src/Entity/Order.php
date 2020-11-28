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
    const STATE_INIT = "init";
    const STATE_WAITING_FOR_CHECK = "waiting_for_check";
    const STATE_WAITING_FOR_CARD = "waiting_for_card";
    const STATE_PAYMENT_CANCELED = "payment_canceled";
    const STATE_PAYMENT_FAILED = "payment_failed";
    const STATE_PAID = "payed";
    const STATE_SENT = "sent";
    const STATE_DELIVER = "delivered";

    const PAYMENT_TYPE_CARD = "carte";
    const PAYMENT_TYPE_CHECK = "cheque";

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="text", length=100, nullable=false)
     */
    private $reference;

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
     * @ORM\Column(name="total_discount", type="float", precision=10, scale=0, nullable=false)
     */
    private $totalDiscount = 0.0;


    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;


    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", nullable=false)
     */
    private $state = self::STATE_INIT;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_type", type="string", nullable=true)
     */
    private $paymentType;

    /**
     * @var int
     *
     * @ORM\Column(name="discount_id", type="integer", nullable=true)
     */
    private $discountId;

    /**
     * @var string
     *
     * @ORM\Column(name="discount_description", type="text", nullable=true)
     */
    private $discountDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="tpp_reference", type="text", length=100, nullable=true)
     */
    private $tppReference;


    /**
     * @var bool
     *
     * @ORM\Column(name="new", type="boolean", nullable=false)
     */
    private $new = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="mail_sent", type="boolean", nullable=false)
     */
    private $mailSent = false;

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
        $this->reference = $this->generateReference();
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
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return Order
     */
    public function setReference(string $reference): Order
    {
        $this->reference = $reference;
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

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     * @return Order
     */
    public function setPaymentType(string $paymentType): Order
    {
        $this->paymentType = $paymentType;
        return $this;
    }


    /**
     * @param string $state
     * @return Order
     */
    public function setState(string $state): Order
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * @param bool $new
     * @return Order
     */
    public function setNew(bool $new): Order
    {
        $this->new = $new;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMailSent(): bool
    {
        return $this->mailSent;
    }

    /**
     * @param bool $mailSent
     * @return Order
     */
    public function setMailSent(bool $mailSent): Order
    {
        $this->mailSent = $mailSent;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalDiscount(): float
    {
        return $this->totalDiscount;
    }

    /**
     * @param float $totalDiscount
     * @return Order
     */
    public function setTotalDiscount(float $totalDiscount): Order
    {
        $this->totalDiscount = $totalDiscount;
        return $this;
    }

    /**
     * @return int
     */
    public function getDiscountId(): ?int
    {
        return $this->discountId;
    }

    /**
     * @param int $discountId
     * @return Order
     */
    public function setDiscountId(int $discountId): Order
    {
        $this->discountId = $discountId;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountDescription(): ?string
    {
        return $this->discountDescription;
    }

    /**
     * @param string $discountDescription
     * @return Order
     */
    public function setDiscountDescription(string $discountDescription): Order
    {
        $this->discountDescription = $discountDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getTppReference(): ?string
    {
        return $this->tppReference;
    }

    /**
     * @param string $tppReference
     * @return Order
     */
    public function setTppReference(string $tppReference): Order
    {
        $this->tppReference = $tppReference;
        return $this;
    }

    public function getBasket()
    {
        $products = explode("/", $this->raw);
        $basket = [];

        foreach ($products as $product) {
            $details = explode("|", $product);
            if (4 === count($details)) {
                $basket[] =
                    [
                        "name" => $details[0],
                        'quantity' => $details[1],
                        'price' => floatval($details[2]),
                        'promoPrice' => $details[3] ? floatval($details[3]) : $details[3]
                    ];
            }

        }

        return $basket;
    }

    public function getFrenchState()
    {
        switch ($this->getState()) {
            case self::STATE_INIT:
                return "Non validée";
            case self::STATE_WAITING_FOR_CHECK:
            case self::STATE_WAITING_FOR_CARD:
                return "En attente";
            case self::STATE_PAYMENT_CANCELED:
                return "Annulée";
            case self::STATE_PAID:
                return "Payée";
            case self::STATE_SENT:
                return "Expédiée";
            case self::STATE_DELIVER:
                return "Livrée";
            default:
                return "Error";
        }
    }

    public function generateReference()
    {
        $date = new \DateTime();
        echo $date->getTimestamp();
        return bin2hex(random_bytes(3)) . $date->getTimestamp();
    }
}
