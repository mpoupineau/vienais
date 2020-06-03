<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bottle
 *
 * @ORM\Table(name="v_vintage", indexes={@ORM\Index(name="fk_foreign_cuvee_id", columns={"cuvee_id"})})
 * @ORM\Entity
 */
class Vintage
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
     * @var Cuvee|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Cuvee")
     * @ORM\JoinColumn(name="cuvee_id", referencedColumnName="id")
     */
    private $cuvee;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority = 0;

    /**
     * @ORM\OneToMany(targetEntity="Bottle", mappedBy="vintage")
     * @ORM\OrderBy({"price" = "ASC"})
     */
    private $bottles;

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

    /**
     * @return mixed
     */
    public function getBottles()
    {
        return $this->bottles;
    }

    /**
     * @param mixed $bottles
     * @return Vintage
     */
    public function setBottles($bottles)
    {
        $this->bottles = $bottles;
        return $this;
    }


}
