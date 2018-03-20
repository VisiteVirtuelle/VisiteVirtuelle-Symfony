<?php

/* 
 * This file is part of the Virtual Visit application. 
 * 
 * Vincent Claveau <vinc.claveau@gmail.com>
 * Guillaume Vidal <guillaume.vidal@lycee-bourdelle.fr>
 * 
 */ 
 
namespace App\Controller\Admin;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/admin", name="admin_")
 */
class DashboardController
{
    private $project_dir;
    
    public function __construct(string $project_dir)
    {
        $this->project_dir = $project_dir;
    }
    
    /**
     * @Route("/", name="dashboard")
     */
    public function dashboard(Environment $twig)
    {
        $xmlFile = $this->project_dir.'/templates/Admin/dashboard_sidebar.xml';
        if(!file_exists($xmlFile)) { throw new NotFoundHttpException($xmlFile." was not found"); }
        
        $xml = simplexml_load_file($xmlFile);
        
        $groups = [];
        foreach($xml->children() as $group)
        {
            array_push($groups, $group);
        }
        
        $urls = [];
        foreach($xml->children() as $url)
        {
            array_push($urls, $url);
        }
        echo "url: ".$url;
        
        return new Response($twig->render('Admin/dashboard.html.twig', [
            'template' => 'Admin/_overview.html.twig',
            'groups' => $groups,
            'urls' => $urls
        ]));
    }
}