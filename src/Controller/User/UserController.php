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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * @Route("/user_", name="user_")
 */
class UserController
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
        $users = $this->userRepository->findAll();

        return new Response($twig->render('User/list.html.twig', [
            'users' => $users
        ]));
    }
}
