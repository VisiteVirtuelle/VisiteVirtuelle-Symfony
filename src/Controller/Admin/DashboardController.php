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
     * @Route("/{template}", name="dashboard")
     */
    public function dashboard($template, Environment $twig)
    {
        $xmlFile = $this->project_dir.'/config/dashboard_sidebar.xml';
        if(!file_exists($xmlFile)) { throw new NotFoundHttpException($xmlFile." was not found"); }
        $xml = simplexml_load_file($xmlFile);
        
        $groups = [];
        foreach ($xml->children() as $group)
        {
            array_push($groups, $group);
        }
        
        $links = [];
        foreach ($xml->children() as $link)
        {
            array_push($links, $link);
        }
        
        $path = 'Admin/_overview.html.twig';
        foreach ($xml->links->children() as $link)
        {
            if ($template == strtolower($group->link->name))
            {
                $path = $group->link->url;
                break;
            }
        }
        
        return new Response($twig->render('Admin/dashboard.html.twig', [
            'template' => $path,
            'groups' => $groups,
            'links' => $links
        ]));
    }
}