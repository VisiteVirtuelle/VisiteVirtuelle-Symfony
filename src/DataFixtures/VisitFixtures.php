<?php

/* 
 * This file is part of the Virtual Visit application. 
 * 
 * Vincent Claveau <vinc.claveau@gmail.com> 
 * 
 */ 
 
namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Entity\Visit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class VisitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userRepository = $manager->getRepository(User::class);
        
        foreach ($this->getData() as [$name, $owner])
        {
            $visit = new Visit();
            $visit->setName($name);
            $visit->setOwner($userRepository->findOneBy(['username' => $owner]));
            
            $manager->persist($visit);
        }
        
        $manager->flush();
    }
    
    private function getData(): array
    {
        return [
            // $visitData = [$name, $owner];
            ['Antoine Bourdelle', 'Pillon'],
            ['Dance', 'Pillon'],
            ['Villes', 'agent'],
            ['Louvre', 'agent'],
            ['Chalet', 'agent'],
        ];
    }
    
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}