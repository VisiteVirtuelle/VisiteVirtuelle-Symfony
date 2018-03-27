<?php

namespace App\Controller\User;

use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * @Route("/user_", name="user_")
 */
class UserController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(RegistryInterface $doctrine, Environment $twig)
    {
        $users = $doctrine->getRepository(User::class)->findAll();
        
        return new Response($twig->render('User/list.html.twig', [
            'users' => $users
        ]));
    }
}