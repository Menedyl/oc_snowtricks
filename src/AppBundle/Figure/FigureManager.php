<?php

namespace AppBundle\Figure;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Figure;
use AppBundle\Entity\User;

class FigureManager
{
    protected $em;

    /**
     * FigureManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Figure $figure
     * @param User $user
     */
    public function add(Figure $figure, User $user)
    {

        $figure->setUser($user);

        $this->em->persist($figure);
        $this->em->flush();
    }

    /**
     * @param Figure $figure
     * @param Collection $ancientImages
     * @param Collection $ancientVideos
     */
    public function edit(Figure $figure, Collection $ancientImages, Collection $ancientVideos)
    {

        foreach ($ancientImages as $image) {
            if (!$figure->getImages()->contains($image)) {
                $this->em->remove($image);
            }
        }

        foreach ($ancientVideos as $video) {
            if (!$figure->getVideos()->contains($video)) {
                $this->em->remove($video);
            }
        }

        $this->em->persist($figure);
        $this->em->flush();
    }

    /**
     * @param Collection $collection
     * @return ArrayCollection
     */
    public function saveTemp(Collection $collection)
    {
        $save = new ArrayCollection();

        foreach ($collection as $item) {
            $save->add($item);
        }

        return $save;
    }

    /**
     * @param Figure $figure
     */
    public function delete(Figure $figure)
    {
        $this->em->remove($figure);
        $this->em->flush();
    }

}