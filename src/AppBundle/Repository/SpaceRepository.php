<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SpaceRepository
 *
 * @package AppBundle\Repository
 */
class SpaceRepository extends EntityRepository
{
    public function findAllEnabled()
    {
        $qb = $this->createQueryBuilder('_s');
        return $qb
            ->andWhere('_s.enabled = true')
            ->andWhere('_s.closed = false')
            ->getQuery()
            ->execute()
        ;
    }

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

        if (!empty($params['user'])) {
            $qb->andWhere('s.owner = :owner')->setParameter('owner', $params['user']);
        }

        if (!empty($params['enabled'])) {
            $qb->andWhere('s.enabled = :enabled')->setParameter('enabled', $params['enabled']);
            $qb->andWhere('s.limitAvailability >= :limitAvailability')->setParameter('limitAvailability', new \DateTime('now'));
        }
        
        if (isset($params['closed'])) {
            $qb->andWhere('s.closed = :closed OR s.limitAvailability < :limitAvailability')->setParameter('closed', $params['closed'])->setParameter('limitAvailability', new \DateTime('now'));
        }

        if (!empty($params['limitAvailability'])) {
            $qb->andWhere('s.limitAvailability >= :limitAvailability')->setParameter('limitAvailability', $params['limitAvailability']);
        }

        if (!empty($params['zipCode'])) {
            $qb->andWhere('s.zipCode LIKE :zipCode')->setParameter('zipCode', $params['zipCode'] . '%' );
        }

        if (!empty($params['localType'])) {
            $qb->andWhere('p.type = :localType')->setParameter('localType', $params['localType'] );
        }

        if (!empty($params['minimumPrice'])) {
            $qb->andWhere('s.price >= :minimumPrice')->setParameter('minimumPrice', $params['minimumPrice'] );
        }

        if (!empty($params['maximumPrice'])) {
            $qb->andWhere('s.price <= :maximumPrice')->setParameter('maximumPrice', $params['maximumPrice'] );
        }

        if (!empty($params['minimumSurface'])) {
            $qb->andWhere('p.surface >= :minimumSurface')->setParameter('minimumSurface',$params['minimumSurface'] );
        }

        if (!empty($params['maximumSurface'])) {
            $qb->andWhere('p.surface <= :maximumSurface')->setParameter('maximumSurface',$params['maximumSurface'] );
        }

        if (!empty($params['orderBy'])) {
            $qb->orderBy('s.'.$params['orderBy'], $params['sort']);
        } else {
            $qb->orderBy('s.name', 'ASC');
        }

        return $qb->getQuery()->getResult();
    }
}
