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
}
