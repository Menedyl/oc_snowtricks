<?php

namespace AppBundle\Manager;


use AppBundle\Entity\Comment;
use AppBundle\Entity\Figure;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CommentManager
{

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * CommentManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Comment $comment
     * @param Figure $figure
     * @param User $user
     */
    public function add(Comment $comment, Figure $figure, User $user)
    {

        $figure->addComment($comment);
        $comment->setUser($user);

        $this->em->persist($comment);
        $this->em->flush();
    }
}