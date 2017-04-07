<?php

namespace AppBundle\Manager;


use AppBundle\Entity\Avatar;
use Doctrine\ORM\EntityManagerInterface;

class AvatarManager
{

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Avatar $avatar)
    {
        $this->em->persist($avatar);
        $this->em->flush();
    }

}