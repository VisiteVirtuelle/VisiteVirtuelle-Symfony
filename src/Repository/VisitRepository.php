<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Vincent Claveau <vinc.claveau@gmail.com>
 *
 */

namespace App\Repository;

use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class VisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visit::class);
    }

    /**
     * @param $owner
     * @return Visit[]
     */
    public function findVisitsByOwner($owner): array
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.owner = :owner')
            ->orderBy('v.id', 'ASC')
            ->getQuery();

        return $qb->execute();
    }
}
