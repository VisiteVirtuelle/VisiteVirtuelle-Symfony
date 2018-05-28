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
 * @Route("/user_", name="user_")   //Route d'accès à la classe
 */
class UserController extends Controller //Classe dédié aux acions lié à la table user
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
     * @Route("/sortby/{column}", name="list_ordered")  //Route d'accès à la fonction
     */
    public function listOrderedBy($column, Environment $twig)   //Fonction de récupération et de tri des données de la table user
    {
        $sortList = $this->getDoctrine()    //$sortList est le service Doctrine qui nous permet de gérer la base de données
            ->getRepository(User::class)    //Récupère le repository UserRepository
            ->querySort($column);   //Tri dans l'ordre du champ $column qui est une variable envoyé par le lien des champs
        
        return new Response($twig->render('User/list.html.twig', [  //Envoie $sortList à la Vue list.html.twig
            'sortList' => $sortList
        ]));
    }
}






