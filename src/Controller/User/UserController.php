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
 * @Route("/user_", name="user_")
 */
class UserController extends Controller
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
     * @Route("/sortby/{column}", name="list_ordered")
     */
    public function listOrderedBy($column, Environment $twig)
    {
        $sortList = $this->getDoctrine()
            ->getRepository(User::class)
            ->querySort($column);
        
        return new Response($twig->render('User/list.html.twig', [
            'sortList' => $sortList
        ]));
    }
}