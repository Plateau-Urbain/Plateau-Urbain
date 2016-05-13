<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getByTypeQueryBuilder($type)
    {
        return $this->createQueryBuilder('u')
           ->where('u.typeUser = :typeUser')
           ->orderBy('u.lastname', 'DESC')
           ->setParameters(array(
               'typeUser' => $type,
           ));
    }

    public function getByType($type)
    {
        return $this->getByTypeQueryBuilder($type)->getQuery()->getResult();
    }
}
