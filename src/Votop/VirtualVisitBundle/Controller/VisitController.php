<?php

namespace Votop\VirtualVisitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VisitController extends Controller
{
    public function indexAction()
    {
        return $this->render('VotopVirtualVisitBundle:Visit:index.html.twig');
    }
    
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $visit = $em->getRepository('VotopVirtualVisitBundle:Visit')->find($id);
        
        if (null === $visit) {
            throw new NotFoundHttpException("Visit with ID ".$id." doesn't exist!");
        }
    
        return $this->render('VotopVirtualVisitBundle:Visit:view.html.twig', array(
            'visit' => $visit
        ));
    }
}
