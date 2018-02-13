<?php

namespace Votop\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('VotopAdminBundle:dashboard:dashboard.html.twig');
    }
}
