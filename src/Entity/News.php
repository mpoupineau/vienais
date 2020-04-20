<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * News
 *
 * @ORM\Table(name="v_news")
 * @ORM\Entity
 */
class News
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
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=true)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=128)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="homePage", type="boolean", nullable=false)
     */
    private $homePage = false;

    /**
     *
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return News
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param string|null $imagePath
     * @return News
     */
    public function setImagePath(?string $imagePath)
    {
        $this->imagePath = $imagePath;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     * @return News
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return News
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return News
     */
    public function setText(string $text)
    {
        $this->text = $text;
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
     * @return News
     */
    public function setVisible(bool $visible)
    {
        $this->visible = $visible;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHomePage()
    {
        return $this->homePage;
    }

    /**
     * @param bool $homePage
     * @return News
     */
    public function setHomePage(bool $homePage)
    {
        $this->homePage = $homePage;
        return $this;
    }

    /**
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $createdAt
     * @return News
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }


}