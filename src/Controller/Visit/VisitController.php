<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Vincent Claveau <vinc.claveau@gmail.com>
 *
 */

namespace App\Controller\Visit;

use App\Entity\User;
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
     * @Route("/list/{view}-{owner_id}",
     *  requirements={"owner_id": "\d+"},
     *  defaults={"view" = "card", "owner_id" = null},
     *  name="list")
     */
    public function list($view, $owner_id, Environment $twig, RegistryInterface $doctrine)
    {
        $visits = $doctrine->getRepository(Visit::class);
        $owner = null;

        if($owner_id === null)
        {
            $visits = $visits->findAll();
        } else {
            $visits = $visits->findBy(['owner' => $owner_id]);
            $owner = $doctrine->getRepository(User::class)->find($owner_id);
        }

        $template = "";
        switch($view)
        {
            case "card":
                $template = 'visit/list_card.html.twig';
                break;
            case "row":
                $template = 'visit/list_row.html.twig';
                break;
            default:
                throw new NotFoundHttpException("This view mode doesn't exist!");
                break;
        }

        return new Response($twig->render($template, [
            'visits' => $visits,
            'owner' => $owner
        ]));
    }
}
