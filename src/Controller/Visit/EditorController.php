<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Vincent Claveau <vinc.claveau@gmail.com>
 *
 */

namespace App\Controller\Visit;

use App\Events;
use App\Entity\Visit;
use App\Form\VisitType;
use App\Repository\VisitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/editor", name="visit_editor_")
 */
class EditorController extends Controller
{
    private $eventDispatcher;
    private $tokenStorage;
    private $visitRepository;
    private $visits_dir;

    public function __construct(EventDispatcherInterface $eventDispatcher, TokenStorageInterface $tokenStorage, VisitRepository $visitRepository, string $project_dir)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage = $tokenStorage;
        $this->visitRepository = $visitRepository;
        $this->visits_dir = $project_dir.'/public/visit/';
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $visit = new Visit();
        $visit->setOwner($this->tokenStorage->getToken()->getUser());

        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // On enregistre la visite dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($visit);
            $em->flush();

            // Création du répertoire contenant le XML et les photos
            $this->updateVisitXML($visit->getID());

            // On déclenche l'event
            $event = new GenericEvent($visit);
            $this->eventDispatcher->dispatch(Events::VISIT_EDITOR_NEW_SUCCESS, $event);

            return $this->redirectToRoute('visit_show', [
                'id' => $visit->getId()
            ]);
        }

        return $this->render('visit/editor/edit.html.twig', [
            'form' => $form->createView(),
            'visit' => $visit
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"}, name="edit")
     */
    public function edit($id, Request $request, AuthorizationCheckerInterface $authChecker)
    {
        $visit = $this->visitRepository->find($id);

        if ($visit === null)
        {
            throw new NotFoundHttpException("This visit doesn't exist!");
        }

        if(false === $authChecker->isGranted('ROLE_ADMIN') && $visit->getOwner() != $this->tokenStorage->getToken()->getUser())
        {
            throw new AccessDeniedException('You\'re not authorized to modify this visit !');
        }

        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);
        //$form->get('cover')->setData($this->visit_dir.$id.'/cover.jpg');

        if ($form->isSubmitted() && $form->isValid())
        {
            // On enregistre la visite dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($visit);
            $em->flush();

            //On déclenche l'event
            $event = new GenericEvent($visit);
            $this->eventDispatcher->dispatch(Events::VISIT_EDITOR_EDIT_SUCCESS, $event);

            return $this->redirectToRoute('visit_show', [
                'id' => $visit->getId()
            ]);
        }

        return $this->render('visit/editor/edit.html.twig', [
            'form' => $form->createView(),
            'visit' => $visit
        ]);
    }

    /**
     * @Route("/test/{id}", requirements={"id": "\d+"}, name="test")
     */
    public function test($id)
    {
        $visit = $this->visitRepository->find($id);

        if ($visit === null)
        {
            throw new NotFoundHttpException("This visit doesn't exist!");
        }

        return $this->render('visit/editor/test.html.twig', [
            'visit' => $visit
        ]);
    }


    private function createVisitRepository($id)
    {
        $visitPath = $this->visits_dir.$id;

        // Création du répertoire de la visite
        $filesystem = new Filesystem();
        $filesystem->mkdir($visitPath.'/img');

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><visit></visit>');
        $xml->asXML($visitPath.'/visit.xml');
    }

    private function updateVisitXML($id)
    {
        $xmlPath = $this->visits_dir.$id.'/visit.xml';

        // Création du répertoire de la visite si il est inexistant
        if(!file_exists($xmlPath))
        {
            $this->createVisitRepository($id);
        }

        // Chargement du fichier XML
        $xmlFileContents = file_get_contents($xmlPath);
        $xml = new \SimpleXMLElement($xmlFileContents);

        // Création d'une pièce
        $room = $xml->addChild('room');
        $room->addChild('name', 'test');
        $room->addChild('url', 'test.jpg');

        // Sauvegarde du XML
        $xml->asXML($xmlPath);
    }
}
