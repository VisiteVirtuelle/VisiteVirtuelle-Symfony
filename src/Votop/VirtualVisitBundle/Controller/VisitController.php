<?php

namespace Votop\VirtualVisitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class VisitController extends Controller
{
    public function indexAction()
    {
        return $this->render('VotopVirtualVisitBundle:Visit:visit.html.twig');
    }
	
	public function viewAction($id)
	{
		return new Response("Visit ID: ".$id);
	}
}
