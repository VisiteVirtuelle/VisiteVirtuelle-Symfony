<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
    
    public function querySort($column): array
    {
        $entityManager = $this->getEntityManager();
        
        switch ($column)
        {
            case 'id':
                $qb = $this->createQueryBuilder('list')
                    ->orderBy('list.id', 'ASC')
                    ->getQuery();
                break;
                
            case 'fullname':
                $qb = $this->createQueryBuilder('list')
                    ->orderBy('list.fullName', 'ASC')
                    ->getQuery();
                break;
                
            case 'username':
                $qb = $this->createQueryBuilder('list')
                    ->orderBy('list.username', 'ASC')
                    ->getQuery();
                break;
                
            case 'email':
                $qb = $this->createQueryBuilder('list')
                    ->orderBy('list.email', 'ASC')
                    ->getQuery();
                break;
                
            default:
                $qb = $this->createQueryBuilder('list')
                    ->orderBy('list.id', 'ASC')
                    ->getQuery();
                break;
        }
        
        return $qb->execute();
    }
}
