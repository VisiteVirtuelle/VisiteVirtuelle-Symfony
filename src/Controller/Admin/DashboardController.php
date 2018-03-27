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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @Route("/{template}", defaults={"template"=""}, name="dashboard")
     */
    public function dashboard($template, Environment $twig)
    {
        $xmlFile = $this->project_dir.'/config/dashboard_sidebar.xml';
        if(!file_exists($xmlFile)) { throw new NotFoundHttpException($xmlFile." was not found"); }
        $xml = simplexml_load_file($xmlFile);
        
        $path = 'User\\UserController::list';
        
        $sidebarData = [
            'group',
            'link'
        ];
        
        $groups = [];
        foreach ($xml->children() as $group)
        {
            $sidebarObj = new SidebarStruct();
            $sidebarObj->name = $group['name'];
            
            $links = [];
            foreach ($group->children() as $link)
            {
                array_push($links, $link['name']);

                if ($template == strtolower($link['name']))
                {
                    $path = $link;
                    $sidebarData['group'] = $group['name'];
                    $sidebarData['link'] = $link['name'];
                }
            }

            $sidebarObj->links = $links;
            array_push($groups, $sidebarObj);
        }
        
        return new Response($twig->render('Admin/dashboard.html.twig', [
            'path' => $path,
            'groups' => $groups,
            'sidebarData' => $sidebarData
            
        ]));
    }
    
    /**
     * @Route("/overview", name="overview")
     */
    public function overview(RegistryInterface $doctrine, Environment $twig)
    {
        $users = $doctrine->getRepository(User::class)->findAll();
        
        return new Response($twig->render('Admin/overview.html.twig', [
            'users' => $users
        ]));
    }
}

class SidebarStruct
{
    public $name;
    public $links;
    
    public $group;
    public $link;
}