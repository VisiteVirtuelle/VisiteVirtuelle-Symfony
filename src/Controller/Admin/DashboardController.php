<?php

/* 
 * This file is part of the Virtual Visit application. 
 * 
 * Vincent Claveau <vinc.claveau@gmail.com>
 * Guillaume Vidal <guillaume.vidal@lycee-bourdelle.fr>
 * 
 */ 
 
namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\Config\FileLocator;
use Symfony\Bridge\Doctrine\RegistryInterface;
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
     * @Route("/{template}", defaults={"template"=""}, name="dashboard")
     */
    public function dashboard($template, Environment $twig, RegistryInterface $doctrine)
    {
        $xmlFile = $this->project_dir.'/config/dashboard_sidebar.xml';
        if(!file_exists($xmlFile)) { throw new NotFoundHttpException($xmlFile." was not found"); }
        $xml = simplexml_load_file($xmlFile);
        
        $path = 'Admin/_overview.html.twig';     
        $users = $doctrine->getRepository(User::class)->findAll();
        
        $groups = [];
        foreach ($xml->children() as $group)
        {
            $groupObj = new GroupStruct();
            $groupObj->name = $group['name'];
            
            $links = [];
            foreach ($group->children() as $link)
            {
                array_push($links, $link['name']);
                
                if ($template == strtolower($link['name']))
                {
                    $path = $link;
                }
            }
            
            $groupObj->links = $links;
            array_push($groups, $groupObj);
        }
        
        return new Response($twig->render('Admin/dashboard.html.twig', [
            'groups' => $groups,
            'path' => $path,
            'users' => $users
        ]));
    }
}

class GroupStruct
{
    public $name;
    public $links;
}