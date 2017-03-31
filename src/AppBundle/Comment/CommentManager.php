<?php

namespace AppBundle\Comment;


use AppBundle\Entity\Comment;
use AppBundle\Entity\Figure;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class CommentManager
{

    protected $em;

    /**
     * CommentManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
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