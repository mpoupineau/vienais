<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PromoCode
 *
 * @ORM\Table(name="v_promo_code")
 * @ORM\Entity
 */
class PromoCode
{
    const TYPE_FEES = 'FEES';
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
     * @ORM\Column(name="code", type="string", length=30, nullable=false)
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiry_date", type="datetime", nullable=false)
     */
    private $expiryDate;

    /**
     * @var float
     *
     * @ORM\Column(name="fixed_reduction", type="float", precision=10, scale=0, nullable=true)
     */
    private $fixedReduction;

    /**
     * @var float
     *
     * @ORM\Column(name="variable_reduction", type="float", precision=10, scale=0, nullable=true)
     */
    private $variableReduction;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PromoCode
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param null|string $code
     * @return PromoCode
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return PromoCode
     */
    public function setType(?string $type): PromoCode
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return PromoCode
     */
    public function setDescription(string $description): PromoCode
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     * @return PromoCode
     */
    public function setStartDate(\DateTime $startDate): PromoCode
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpiryDate(): \DateTime
    {
        return $this->expiryDate;
    }

    /**
     * @param \DateTime $expiryDate
     * @return PromoCode
     */
    public function setExpiryDate(\DateTime $expiryDate): PromoCode
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    /**
     * @return float
     */
    public function getFixedReduction(): ?float
    {
        return $this->fixedReduction;
    }

    /**
     * @param float $fixedReduction
     * @return PromoCode
     */
    public function setFixedReduction(float $fixedReduction): PromoCode
    {
        $this->fixedReduction = $fixedReduction;
        return $this;
    }

    /**
     * @return float
     */
    public function getVariableReduction(): ?float
    {
        return $this->variableReduction;
    }

    /**
     * @param float $variableReduction
     * @return PromoCode
     */
    public function setVariableReduction(float $variableReduction): PromoCode
    {
        $this->variableReduction = $variableReduction;
        return $this;
    }

    public function isValid()
    {
        return new \DateTime('now') < $this->getExpiryDate();
    }
}
