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
use App\Entity\Visit;
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
     * @Route("/{template}", defaults={"template"=""}, name="dashboard")    //Route d'accès à la fonction
     */
    public function dashboard($template, Environment $twig) //Fonction de l'exploitation du fichier xml
    {
        $xmlFile = $this->project_dir.'/config/dashboard_sidebar.xml';  //Enregistre le fichier xml dans $xmlFile
        if(!file_exists($xmlFile)) { throw new NotFoundHttpException($xmlFile." was not found"); }  //Affiche une erreur si le fichier n'est pas trouvé
        $xml = simplexml_load_file($xmlFile);   //Convertit $xmlFile en objet
        
        //$path contient la route d'un Controller, au premier appel de la fonction $path est vide
        $path = 'User\\UserController::list';   //Pour ne pas rien afficher, $path est initialiser avec la route du Controller User
                                                //puis vers la fonction list qui liste les utilisateurs inscrits
        
        $sidebarData = [    //Contiendra le nom du groupe et de la route du lien
            'group' => '',
            'link' => ''
        ];
        
        $groups = [];
        foreach ($xml->children() as $group)    //Parcours du fichier
        {
            $sidebarObj = new SidebarStruct();  //Voir structure de la classe
            $sidebarObj->name = $group['name']; //L'attribut name contient les noms de groupes
            
            $links = [];
            foreach ($group->children() as $link)   //Parcours du groupe
            {
                array_push($links, $link['name']);  //$links[] contient les noms des liens

                if ($template == strtolower($link['name'])) //$links[] contient les noms des liens
                {
                    $path = $link;  //$path contient la route du lien
                    $sidebarData['group'] = $group['name']; //$sidebarData['group'] contient le nom de groupe du lien 
                    $sidebarData['link'] = $link['name'];   //$sidebarData['link'] contient le nom de la route du lien
                }
            }

            $sidebarObj->links = $links;    //L'attribut links contient les noms des liens
            array_push($groups, $sidebarObj);   //$groups contient les noms de groupes et les noms des liens
        }
        
        return new Response($twig->render('Admin/dashboard.html.twig', [    //Permet d'envoyer les variables à la Vue dashboard.html.twig
            'path' => $path,
            'groups' => $groups,
            'sidebarData' => $sidebarData
        ]));
    }
    
    
    
    
    /**
     * @Route("/overview", name="overview") //Route d'accès à la focntion
     */
    public function overview(RegistryInterface $doctrine, Environment $twig)    //Fonction d'xploitation des données de la table user et visit
    {
        $users = $doctrine->getRepository(User::class)->findAll();  //$users contient toute les données de la table user
        $visits = $doctrine->getRepository(Visit::class)->findAll();    //$visits contient toute les données de la table visit
        
        $visitOwnerList = [];
        foreach ($visits as $visit)
        {
            array_push($visitOwnerList, $visit->getOwner()->getUsername());
        }
        
        $ownerVisit = [];
        $ownerVisit = array_fill(0, 6, '');
        $nbVisit = [];
        $nbVisit = array_fill(0, 6, 0);
        $visitOwnerPrev = '';
        sort($visitOwnerList);
        $i = 0; $j = 0; $k = 0;
        foreach ($visitOwnerList as $owner)
        {
            if ($k > 0)
            {
                $visitOwnerPrev = $visitOwnerList[$k - 1];
            }
            else
            {
                $visitOwnerPrev = $owner;
                $ownerVisit[$i] = $owner;
            }
            
            if ($owner == $visitOwnerPrev)
            {
                $j++;
                $nbVisit[$i] = $j;
            }
            else
            {
                $i++;
                $j = 1;
                $nbVisit[$i] = $j;
                $ownerVisit[$i] = $owner;
            }
            
            $k++;
        }
        
        do {
            $change = false;
            
            for ($i = 0; $i < count($ownerVisit) - 1; $i++)
            {
                if($nbVisit[$i] < $nbVisit[$i + 1])
                {
                    $tmpNb = $nbVisit[$i];
                    $nbVisit[$i] = $nbVisit[$i + 1];
                    $nbVisit[$i + 1] = $tmpNb;
                    
                    $tmpOw = $ownerVisit[$i];
                    $ownerVisit[$i] = $ownerVisit[$i + 1];
                    $ownerVisit[$i + 1] = $tmpOw;
                    
                    $change = true;
                }
            }
        } while($change);
        
        return new Response($twig->render('Admin/overview.html.twig', [
            'users' => $users,
            'nbVisit' => $nbVisit,
            'ownerVisit' => $ownerVisit
        ]));
    }
}

class SidebarStruct
{
    public $name;
    public $links;
}