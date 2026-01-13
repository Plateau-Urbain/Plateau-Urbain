<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class Repository
 *
 * @package AppBundle\Repository
 */
class ActualityRepository extends EntityRepository
{
    public function findPublished()
    {
        $qb = $this->createQueryBuilder('a');
        return $qb
            ->andWhere('a.published = true')
            ->orderBy('a.date', 'DESC')
            ->getQuery()
            ->execute()
        ;
    }
}
