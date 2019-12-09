<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuvee
 *
 * @ORM\Table(name="cuvee")
 * @ORM\Entity
 */
class Cuvee
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var WineType
     *
     * @ORM\ManyToOne(targetEntity="WineType")
     * @ORM\JoinColumn(name="wine_type_id", referencedColumnName="id")
     */
    private $wineType;

    /**
     * @var string
     *
     * @ORM\Column(name="variety", type="text", nullable=true)
     */
    private $variety;

    /**
     * @var string
     *
     * @ORM\Column(name="vinification", type="text", nullable=true)
     */
    private $vinification;

    /**
     * @var string
     *
     * @ORM\Column(name="tasting", type="text", nullable=true)
     */
    private $tasting;

    /**
     * @var string
     *
     * @ORM\Column(name="accord", type="text", nullable=true)
     */
    private $accord;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_path", type="string", length=255, nullable=true)
     */
    private $imagePath;


    private $imageFile;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible = true;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Cuvee
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     * @return Cuvee
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Cuvee
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return WineType
     */
    public function getWineType()
    {
        return $this->wineType;
    }

    /**
     * @param WineType $wineType
     * @return Cuvee
     */
    public function setWineType(WineType $wineType)
    {
        $this->wineType = $wineType;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param null|string $imagePath
     * @return Cuvee
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
        return $this;
    }


    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
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
     * @return Cuvee
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
        return $this;
    }

    /**
     * @return string
     */
    public function getVariety()
    {
        return $this->variety;
    }

    /**
     * @param string $variety
     * @return Cuvee
     */
    public function setVariety(string $variety): Cuvee
    {
        $this->variety = $variety;
        return $this;
    }

    /**
     * @return string
     */
    public function getVinification()
    {
        return $this->vinification;
    }

    /**
     * @param string $vinification
     * @return Cuvee
     */
    public function setVinification(string $vinification): Cuvee
    {
        $this->vinification = $vinification;
        return $this;
    }

    /**
     * @return string
     */
    public function getTasting()
    {
        return $this->tasting;
    }

    /**
     * @param string $tasting
     * @return Cuvee
     */
    public function setTasting(string $tasting): Cuvee
    {
        $this->tasting = $tasting;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccord()
    {
        return $this->accord;
    }

    /**
     * @param string $accord
     * @return Cuvee
     */
    public function setAccord(string $accord): Cuvee
    {
        $this->accord = $accord;
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
