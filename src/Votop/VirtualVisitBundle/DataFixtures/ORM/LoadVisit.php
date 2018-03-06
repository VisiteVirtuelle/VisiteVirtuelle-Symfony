<?php

namespace Votop\VirtualVisitBundle\DataFixtures\ORM;

use Votop\VirtualVisitBundle\Entity\Visit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadVisit extends Fixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) 
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        
        $visits = array(
            array(
                "name" => "Appartement 3 pièces à vendre à Montauban",
                "owner" => "agent"
            ),
            array(
                "name" => "Maison 3 pièces à vendre à Montauban",
                "owner" => "agent"
            ),
            array(
                "name" => "Maison 4 pièces à vendre à Montauban",
                "owner" => "agent1"
            ),
            array(
                "name" => "Terrain 2 300 m² à vendre à Corbarieu",
                "owner" => "agent2"
            ),
            array(
                "name" => "Appartement 3 pièces à vendre à Toulouse",
                "owner" => "agent3"
            )
        );
		
        foreach ($visits as $v) {
            $visit = new Visit();

            $visit->setName($v["name"]);
            $visit->setOwner($userManager->findUserBy(array('username' => $v["owner"])));

            $manager->persist($visit);
        }

        $manager->flush();
    }
}