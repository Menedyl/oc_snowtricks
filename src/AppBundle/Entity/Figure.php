<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Figure
 *
 * @ORM\Table(name="figure")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FigureRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Figure
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * @var string
     *
     * @ORM\Column(name="group_figure", type="string", length=255, nullable=true)
     */
    private $groupFigure;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="datetime")
     */
    private $dateCreate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Image", mappedBy="figure", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $images;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Video", mappedBy="figure", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $videos;


    public function __construct()
    {
        $this->dateCreate = new \DateTime();
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {

        $this->setDateModif(new \DateTime());
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Figure
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Figure
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get rating
     *
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return Figure
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * Get groupFigure
     *
     * @return string
     */
    public function getGroupFigure()
    {
        return $this->groupFigure;
    }

    /**
     * Set groupFigure
     *
     * @param string $groupFigure
     *
     * @return Figure
     */
    public function setGroupFigure($groupFigure)
    {
        $this->groupFigure = $groupFigure;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     *
     * @return Figure
     */
    public function setDateCreate(\DateTime $dateCreate)
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * Get dateModif
     *
     * @return \DateTime
     */
    public function getDateModif()
    {
        return $this->dateModif;
    }

    /**
     * Set dateModif
     *
     * @param \DateTime $dateModif
     *
     * @return Figure
     */
    public function setDateModif(\DateTime $dateModif)
    {
        $this->dateModif = $dateModif;
    }

    /**
     * Add image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Figure
     */
    public function addImage(\AppBundle\Entity\Image $image)
    {
        $this->images->add($image);

        $image->setFigure($this);
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\Image $image
     */
    public function removeImage(\AppBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add video
     *
     * @param \AppBundle\Entity\Video $video
     *
     * @return Figure
     */
    public function addVideo(\AppBundle\Entity\Video $video)
    {
        $this->videos->add($video);

        $video->setFigure($this);
    }

    /**
     * Remove video
     *
     * @param \AppBundle\Entity\Video $video
     */
    public function removeVideo(\AppBundle\Entity\Video $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }
}
