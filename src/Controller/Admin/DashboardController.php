<?php

/* 
 * This file is part of the Virtual Visit application. 
 * 
 * Vincent Claveau <vinc.claveau@gmail.com> 
 * 
 */ 
 
namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/admin", name="admin_")
 */
class DashboardController
{
     /**
     * @Route("/", name="dashboard_index")
     */
    public function index(Environment $twig)
    {
        return new Response($twig->render('Admin/index.html.twig'));
    }
}