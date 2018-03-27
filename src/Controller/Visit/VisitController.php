<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Vincent Claveau <vinc.claveau@gmail.com>
 *
 */

namespace App\Controller\Visit;

use App\Entity\Visit;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/visit", name="visit_")
 */
class VisitController
{
    /**
     * @Route("/{id}", requirements={"id": "\d+"}, name="show")
     */
    public function show($id, Environment $twig, RegistryInterface $doctrine)
    {
        $visit = $doctrine->getRepository(Visit::class)->find($id);

        if (null === $visit)
        {
            throw new NotFoundHttpException("This visit doesn't exist!");
        }

        return new Response($twig->render('visit/show.html.twig', [
            'visit' => $visit
        ]));
    }

    /**
     * @Route("/list/{id}", requirements={"id": "\d+"}, defaults={"id" = null}, name="list")
     */
    public function list($id, Environment $twig, RegistryInterface $doctrine)
    {
        $visits = $doctrine->getRepository(Visit::class);

        if($id === null)
        {
            $visits = $visits->findAll();
        } else {
            $visits = $visits->findBy(['owner' => $id]);
        }

        return new Response($twig->render('visit/list.html.twig', [
            'visits' => $visits
        ]));
    }
}
