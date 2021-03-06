<?php

namespace AppBundle\Repository;

/**
 * VideoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VideoRepository extends \Doctrine\ORM\EntityRepository
{
    public function findLast($max)
    {

        return $this->createQueryBuilder('v')
            ->innerJoin('v.figure', 'figure')
            ->addSelect('figure')
            ->orderBy('v.dateCreate', 'DESC')
            ->getQuery()
            ->setMaxResults($max)
            ->getResult();

    }
}
