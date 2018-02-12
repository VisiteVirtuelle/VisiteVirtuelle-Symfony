<?php

namespace Votop\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VotopPlatformBundle:Default:index.html.twig');
    }
}
