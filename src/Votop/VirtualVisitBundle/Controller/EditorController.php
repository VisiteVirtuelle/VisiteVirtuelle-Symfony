<?php

namespace Votop\VirtualVisitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EditorController extends Controller
{
    public function indexAction()
    {
        return $this->render('VotopVirtualVisitBundle:Editor:editor.html.twig');
    }
}
