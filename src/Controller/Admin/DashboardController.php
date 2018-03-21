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
     * @Route("/{template}", defaults={"template"=""}), name="dashboard")
     */
    public function dashboard($template, Environment $twig)
    {
        $xmlFile = $this->project_dir.'/config/dashboard_sidebar.xml';
        if(!file_exists($xmlFile)) { throw new NotFoundHttpException($xmlFile." was not found"); }
        $xml = simplexml_load_file($xmlFile);
        
        $path = 'Admin/_overview.html.twig';
        
        $xmlStruct = [];
        $groupName = [];
        $linkName = [];
        
        foreach ($xml->children() as $group)
        {
            array_push($groupName, $group['name']);
            
            foreach ($group->children() as $link)
            {
                array_push($linkName, $link['name']);
                
                if ($template == strtolower($link['name']))
                {
                    $path = $link;
                }
            }
        }
        
        array_push($xmlStruct, $groupName);
        array_push($xmlStruct, $linkName);
        
        return new Response($twig->render('Admin/dashboard.html.twig', [
            'xmlStruct' => $xmlStruct,
            'path' => $path
        ]));
    }
}

/*

$xmlFile = $this->project_dir.'/config/dashboard_sidebar.xml';
        if(!file_exists($xmlFile)) { throw new NotFoundHttpException($xmlFile." was not found"); }
        $xml = simplexml_load_file($xmlFile);
        
        $path = 'Admin/_overview.html.twig';
        
        $groups = [];
        $names = [];
        foreach ($xml->children() as $group)
        {
            array_push($groups, $group['id']);
            
            foreach ($group->children() as $link)
            {
                array_push($names, $link['name']);
                
                if ($template == strtolower($link['name']))
                {
                    $path = $link;
                    break;
                }
            }
        }
        
        $struct = [$groups, $names];
        
        return new Response($twig->render('Admin/dashboard.html.twig', [
            'struct' => $struct,
            'path' => $path
        ]));


$xmlFile = $this->project_dir.'/config/dashboard_sidebar.xml';
if(!file_exists($xmlFile)) { throw new NotFoundHttpException($xmlFile." was not found"); }
$xml = simplexml_load_file($xmlFile);

$path = 'Admin/_overview.html.twig';

$names = [];
foreach ($xml->children() as $group)
{
    foreach ($group->children() as $link)
    {
        array_push($names, $link['name']);
        
        if ($template == strtolower($link['name']))
        {
            $path = $link;
        }
    }
}

return new Response($twig->render('Admin/dashboard.html.twig', [
    'names' => $names,
    'path' => $path
]));

*/