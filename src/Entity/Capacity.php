<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Capacity
 *
 * @ORM\Table(name="capacity")
 * @ORM\Entity
 */
class Capacity
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
     * @var float|null
     *
     * @ORM\Column(name="volume", type="float", precision=10, scale=0, nullable=true)
     */
    private $volume;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Capacity
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
     * @return Capacity
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param float|null $volume
     * @return Capacity
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
        return $this;
    }


}
