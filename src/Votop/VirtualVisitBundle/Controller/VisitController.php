<?php

namespace Votop\VirtualVisitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VisitController extends Controller
{
    public function indexAction()
    {
        return $this->render('VotopVirtualVisitBundle:Visit:visit.html.twig');
    }
}
