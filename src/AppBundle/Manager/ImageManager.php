<?php

namespace AppBundle\Manager;


use AppBundle\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;

class ImageManager
{

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Image $image)
    {
        $this->em->persist($image);
        $this->em->flush();
    }
}