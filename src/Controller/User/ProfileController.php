<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Vincent CLaveau <vinc.claveau@gmail.com>
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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Twig\Environment;

/**
 * @Route("/profile", name="user_profile_")
 */
class ProfileController extends Controller
{
    /**
     * @Route("/", name="show")
     */
    public function show(Environment $twig, TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();

        if(!is_object($user))
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return new Response($twig->render('User/Profile/show.html.twig', [
            'user' => $user
        ]));
    }

    /**
     * @Route("/edit", name="edit")
     * @param Request $request
     */
    public function edit(Request $request, Environment $twig, TokenStorageInterface $tokenStorage, EventDispatcherInterface $eventDispatcher)
    {
        $user = $tokenStorage->getToken()->getUser();

        if(!is_object($user))
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            // On enregistre l'utilisateur dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            //On déclenche l'event
            $event = new GenericEvent($user);
            $eventDispatcher->dispatch(Events::USER_PROFILE_EDIT_SUCCESS, $event);

            return $this->redirectToRoute('user_profile_show');
        }

        return new Response($twig->render('User/Profile/edit.html.twig', [
            'form' => $form->createView()
        ]));
    }
}
