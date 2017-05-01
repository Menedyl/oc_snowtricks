<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * GroupFigure
 *
 * @ORM\Table(name="group_figure")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupFigureRepository")
 */
class GroupFigure
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var Figure
     *
     * @ORM\OneToMany(targetEntity="Figure", mappedBy="groupFigure" )
     */
    private $figures;

    public function __construct()
    {
        $this->figures = new ArrayCollection();
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
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Add figure
     *
     * @param Figure $figure
     */
    public function addFigure(Figure $figure)
    {
        $this->figures->add($figure);
    }

    /**
     * Remove figure
     *
     * @param Figure $figure
     */
    public function removeFigure(Figure $figure)
    {
        $this->figures->removeElement($figure);
    }

    /**
     * Get figures
     *
     * @return Collection
     */
    public function getFigures()
    {
        return $this->figures;
    }
}
