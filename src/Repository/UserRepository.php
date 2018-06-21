<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository    //Repository r�alisant les requ�tes SQL vers la base de donn�es
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
    
    public function querySort($column): array   //Fonction de tri dans l'ordre de $column
    {
        $entityManager = $this->getEntityManager();
        
        switch ($column)    //Les requ�tes SQL trieront les donn�es re�ues selon le champ choisi
        {
            case 'id':
                $qb = $this->createQueryBuilder('list') //$qb est la requ�te, list est l'alias d'acc�s aux champs
                    ->orderBy('list.id', 'ASC') //Tri par ID
                    ->getQuery();   //Retournes en objet Query qui est utilis� pour avoir le r�sultat de la requ�te
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
        
        return $qb->execute();  //Ex�cute la requ�te
    }
}



