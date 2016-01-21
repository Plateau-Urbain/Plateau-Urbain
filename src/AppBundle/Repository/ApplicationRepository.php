<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Application;
use AppBundle\Entity\Space;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * ApplicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ApplicationRepository extends EntityRepository
{
    /**
     * @param User $owner
     *
     * @return array
     */
    public function getApplicationPerOwner(User $owner)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('space')
            ->addSelect('user')
            ->innerJoin('a.space','space')
            ->innerJoin('space.owner','user')
            ->where('space.owner = :user_id')
            ->setParameters(array(
                'user_id' => $owner->getId()
            ));

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $params
     *
     * @return QueryBuilder
     */
    public function filter($params)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a');

        if (!empty($params['space'])) {
            $qb->andWhere('a.space = :space')->setParameter('space', $params['space']);
        }

        if (!empty($params['orderBy'])) {
            $qb->orderBy('a.'.$params['orderBy'], $params['sort']);
            if ($params['orderBy'] === 'lengthOccupation') {
                $qb->addOrderBy('a.lengthTypeOccupation', $params['sort']);
            }
        }

        if (!empty($params['status']) && $params['status'] != 'selected') {
            $qb->andWhere('a.status = :status');
            $qb->setParameter('status', $params['status']);
        }

        if (!empty($params['status']) && $params['status'] == 'selected') {
            $qb->andWhere('a.selected = :selected');
            $qb->setParameter('selected', 1);
        }

        return $qb;
    }

    /**
     * @param Application $application
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNextApplication(Application $application) {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.id > :id')
            ->andWhere('a.space = :space')
            ->setParameter('space', $application->getSpace())
            ->setParameter('id', $application->getId())
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param Application $application
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPrevApplication(Application $application) {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.id < :id')
            ->andWhere('a.space = :space')
            ->setParameter('space', $application->getSpace())
            ->setParameter('id', $application->getId())
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

}
