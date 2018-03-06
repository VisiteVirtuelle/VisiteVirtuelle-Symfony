<?php

namespace Votop\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
	public function indexAction()
	{
		return $this->render('VotopCoreBundle:Core:index.html.twig');
	}
}