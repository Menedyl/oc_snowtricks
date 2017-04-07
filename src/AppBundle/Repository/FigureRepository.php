<?php

namespace AppBundle\Repository;

use AppBundle\Entity\GroupFigure;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * FigureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FigureRepository extends \Doctrine\ORM\EntityRepository
{

    public function findWithImagesAndVideos($id)
    {
        return $this->createQueryBuilder('f')
            ->where('f.id = :id')
            ->setParameter('id', $id)
            ->innerJoin('f.images', 'images')
            ->addSelect('images')
            ->leftJoin('f.videos', 'videos')
            ->addSelect('videos')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findWithAll($id)
    {
        return $this->createQueryBuilder('f')
            ->where('f.id = :id')
            ->setParameter('id', $id)
            ->innerJoin('f.images', 'images')
            ->addSelect('images')
            ->leftJoin('f.videos', 'videos')
            ->addSelect('videos')
            ->leftJoin('f.comments', 'comments')
            ->addSelect('comments')
            ->getQuery()
            ->getOneOrNullResult();

    }

    public function getForPagination($page, $nbPerPage)
    {

        $query = $this->createQueryBuilder('f')
            ->innerJoin('f.images', 'images')
            ->addSelect('images')
            ->leftJoin('f.videos', 'videos')
            ->addSelect('videos')
            ->orderBy('f.dateCreate', 'DESC')
            ->getQuery();

        $query
            ->setFirstResult(($page - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query, true);
    }

    public function findByGroupFigure(GroupFigure $groupFigure, $page, $nbPerPage)
    {

        $query = $this->createQueryBuilder('f')
            ->where('f.groupFigure = :groupFigure')
            ->setParameter('groupFigure', $groupFigure)
            ->getQuery();

        $query
            ->setFirstResult(($page - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query, true);
    }

}
