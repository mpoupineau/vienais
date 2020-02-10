<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity
 */
class Photo
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
     * @ORM\ManyToMany(targetEntity="PhotoTag", inversedBy="photos")
     */
    private $photoTags;

    public function __construct()
    {
        $this->photoTags = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Photo
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return photo
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
     * @return photo
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
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
     * @return photo
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return Collection|PhotoTag[]
     */
    public function getPhotoTags()
    {
        return $this->photoTags;
    }

    public function addPhotoTag(PhotoTag $tag)
    {
        if (!$this->photoTags->contains($tag)) {
            $this->photoTags[] = $tag;
        }
        return $this;
    }

    public function removePhotoTag(PhotoTag $tag)
    {
        if ($this->photoTags->contains($tag)) {
            $this->photoTags->removeElement($tag);
        }
        return $this;
    }

    public function photoTagsToString() {
        $tagsToString = "";
        foreach ($this->photoTags as $tag) {
            $tagsToString .= " " . $tag->getName();
        }
        return $tagsToString;
    }
}