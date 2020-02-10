<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhotoTag
 *
 * @ORM\Table(name="photo_tag")
 * @ORM\Entity
 */
class PhotoTag
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
     * @ORM\ManyToMany(targetEntity="Photo", mappedBy="photoTags")
     */
    private $photos;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PhotoTag
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
     * @return PhotoTag
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
