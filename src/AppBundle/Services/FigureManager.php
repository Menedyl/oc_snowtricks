<?php

namespace AppBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use AppBundle\Entity\Figure;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class FigureManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * FigureManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
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
    public function oldSaveCollection(Collection $collection)
    {
        $oldCollection = new ArrayCollection();

        foreach ($collection as $item) {
            $oldCollection->add($item);
        }

        return $oldCollection;
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