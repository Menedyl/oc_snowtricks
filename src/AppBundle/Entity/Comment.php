<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreate", type="datetime")
     */
    private $dateCreate;

    /**
     * @var Collection
     *
     * @ORM\ManyToOne(targetEntity="Figure", inversedBy="comments")
     */
    private $figure;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     */
    private $user;

    public function __construct()
    {
        $this->dateCreate = new \DateTime();
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
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;
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
     * @return Comment
     */
    public function setDateCreate(\DateTime $dateCreate)
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * Set figure
     *
     * @param \AppBundle\Entity\Figure $figure
     *
     * @return Comment
     */
    public function setFigure(Figure $figure)
    {
        $this->figure = $figure;
    }

    /**
     * Get figure
     *
     * @return \AppBundle\Entity\Figure
     */
    public function getFigure()
    {
        return $this->figure;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Comment
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
