<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Guillaume Vidal <guillaume.vidal@gmail.com>
 *
 */

namespace App\Controller\User;

use App\Entity\User;
use App\Events;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/", name="user_")
 */
class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="registration_register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, EventDispatcherInterface $eventDispatcher)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // Par defaut l'utilisateur aura toujours le rôle ROLE_USER
            $user->setRoles(['ROLE_USER']);

            // On enregistre l'utilisateur dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            //On déclenche l'event
            $event = new GenericEvent($user);
            $eventDispatcher->dispatch(Events::USER_REGISTERED, $event);

            return $this->redirectToRoute('user_security_login');
        }

        return $this->render(
            'User/Registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}
