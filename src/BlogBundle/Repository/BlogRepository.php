<?php

namespace BlogBundle\Repository;

/**
 * BlogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlogRepository extends \Doctrine\ORM\EntityRepository
{
    public function getUserForBlog($blogId)
    {
        $query = $this->createQueryBuilder('b')
            ->innerJoin('b.user','u')
            ->where('b.id = :id')
            ->setParameter('id', $blogId)
            ->setMaxResults(100)
            ->getQuery();
        $result = $query->getResult();
        return $result;
    }
    
}
