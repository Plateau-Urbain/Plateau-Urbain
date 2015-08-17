<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SpaceRepository extends EntityRepository
{
    public function getEnabled()
    {
        return $this->createQueryBuilder('u')
            ->where('u.enabled = :enabled')
            ->orderBy('u.lastname', 'DESC')
            ->setParameters(array(
                'enabled' => true,
            ));
    }



    public function filter($params)
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s')
            ->leftjoin('s.parcels', 'p');

        if (!empty($params['localType'])) {
            $qb->andWhere('p.type = :key')->setParameter('key',$params['localType'] );
        }

        if (!empty($params['minimumPrice'])) {
            $qb->andWhere('s.price > :minimumPrice')->setParameter('minimumPrice', $params['minimumPrice'] );
        }

        if (!empty($params['maximumPrice'])) {
            $qb->andWhere('s.price < :maximumPrice')->setParameter('maximumPrice', $params['maximumPrice'] );
        }

        if (!empty($params['minimumSurface'])) {
            $qb->andWhere('p.surface > :minimumSurface')->setParameter('minimumSurface',$params['minimumSurface'] );
        }

        if (!empty($params['maximumSurface'])) {
            $qb->andWhere('p.surface < :maximumSurface')->setParameter('maximumSurface',$params['maximumSurface'] );
        }

        $qb->orderBy('s.'.$params['orderBy'], $params['sort']);

        return $qb->getQuery()->getResult();
    }
}
