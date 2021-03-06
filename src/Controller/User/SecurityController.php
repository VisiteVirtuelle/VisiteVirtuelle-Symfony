<?php

namespace App\Controller\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

/**
 * @Route("/", name="user_")
 */
class SecurityController
{
    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $helper, Environment $twig) : Response
    {
        return new Response($twig->render('User/Security/login.html.twig', [
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
        ]));
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should be never reached!');
    }
}
