<?php

namespace AppBundle\Services;


use AppBundle\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;

class VideoManager
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Video $video)
    {
        $this->em->persist($video);
        $this->em->flush();

    }

}