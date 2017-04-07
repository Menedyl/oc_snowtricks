<?php

namespace AppBundle\Repository;

/**
 * ImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageRepository extends \Doctrine\ORM\EntityRepository
{
    public function findLast($max)
    {
        return $this->createQueryBuilder('i')
            ->innerJoin('i.figure', 'figure')
            ->addSelect('figure')
            ->orderBy('i.dateCreate', 'DESC')
            ->getQuery()
            ->setMaxResults($max)
            ->getResult();

    }
}
