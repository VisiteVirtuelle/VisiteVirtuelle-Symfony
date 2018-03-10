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
            
            ['1908 N Alvarado St, Los Angeles, CA 90039', 'agent'],
            ['1108 E 131st St, Los Angeles, CA 90059', 'agent'],
            ['1212 S Spaulding Ave, Los Angeles, CA 90019', 'agent'],
            ['500 W 43rd St Apt 6G, Manhattan, NY 10036', 'agent'],
            ['153 Bennett Ave Apt 3G, New York, NY 10040', 'agent'],
            
            ['5670 W Olympic Blvd Apt A05, Los Angeles, CA 90036', 'agent1'],
            ['1521 Greenfield Ave Apt 305, Los Angeles, CA 90025', 'agent1'],
            ['7337 W 87th St, Los Angeles, CA 90045', 'agent1'],
            
            ['3255 Larga Ave, Los Angeles, CA 90039', 'agent2'],
            
            ['441 E 57th St Unit 2, New York, NY 10022', 'agent3'],
            ['400 Fifth Ave Unit 34C, New York, NY 10018', 'agent3'],
            ['418 Central Park W Apt 54, New York, NY 10025', 'agent3'],
        ];
    }
    
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}