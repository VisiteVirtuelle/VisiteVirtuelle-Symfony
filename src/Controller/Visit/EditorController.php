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
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/editor", name="visit_editor_")
 */
class EditorController
{
    /**
     * @Route("/test", name="test")
     */
    public function test(Environment $twig)
    {
        return new Response($twig->render('visit/editor/template.html.twig'));
    }
}
