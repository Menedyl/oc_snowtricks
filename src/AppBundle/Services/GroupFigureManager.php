<?php

namespace AppBundle\Services;


use AppBundle\Entity\GroupFigure;
use Doctrine\ORM\EntityManagerInterface;

class GroupFigureManager
{

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(GroupFigure $groupFigure)
    {
        $this->em->persist($groupFigure);
        $this->em->flush();

    }

}
