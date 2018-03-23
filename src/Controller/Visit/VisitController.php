<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Vincent Claveau <vinc.claveau@gmail.com>
 *
 */

namespace App\Controller\Visit;

use App\Entity\Visit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\RegistryInterface;
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
     * @Route("/list", name="list")
     */
    public function list(Environment $twig, RegistryInterface $doctrine)
    {
        $visits = $doctrine->getRepository(Visit::class)->findAll();

        return new Response($twig->render('visit/list.html.twig', [
            'visits' => $visits
        ]));
    }
}
