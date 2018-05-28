<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Guillaume Vidal <guillaume.vidal@lycee-bourdelle.com>
 *
 */

namespace App\Controller\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/user_", name="user_")   //Route d'acc�s � la classe
 */
class UserController extends Controller //Classe d�di� aux acions li� � la table user
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    /**
     * @Route("/list", name="list")
     */
    public function list(Environment $twig)
    {
        $column = '';
        
        $sortList = $this->getDoctrine()
        ->getRepository(User::class)
        ->querySort($column);
        
        return new Response($twig->render('User/list.html.twig', [
            'sortList' => $sortList
        ]));
    }
    
    /**
     * @Route("/sortby/{column}", name="list_ordered")  //Route d'acc�s � la fonction
     */
    public function listOrderedBy($column, Environment $twig)   //Fonction de r�cup�ration et de tri des donn�es de la table user
    {
        $sortList = $this->getDoctrine()    //$sortList est le service Doctrine qui nous permet de g�rer la base de donn�es
            ->getRepository(User::class)    //R�cup�re le repository UserRepository
            ->querySort($column);   //Tri dans l'ordre du champ $column qui est une variable envoy� par le lien des champs
        
        return new Response($twig->render('User/list.html.twig', [  //Envoie $sortList � la Vue list.html.twig
            'sortList' => $sortList
        ]));
    }
}






