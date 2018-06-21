<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository    //Repository réalisant les requêtes SQL vers la base de données
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
    
    public function querySort($column): array   //Fonction de tri dans l'ordre de $column
    {
        $entityManager = $this->getEntityManager();
        
        switch ($column)    //Les requêtes SQL trieront les données reçues selon le champ choisi
        {
            case 'id':
                $qb = $this->createQueryBuilder('list') //$qb est la requête, list est l'alias d'accès aux champs
                    ->orderBy('list.id', 'ASC') //Tri par ID
                    ->getQuery();   //Retournes en objet Query qui est utilisé pour avoir le résultat de la requête
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
        
        return $qb->execute();  //Exécute la requête
    }
}



