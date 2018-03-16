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
use Symfony\Component\Filesystem\Filesystem;

class VisitFixtures extends Fixture implements DependentFixtureInterface
{
    private $root_dir;

    public function __construct(string $root_dir)
    {
        $this->root_dir = $root_dir;
    }

    public function load(ObjectManager $manager)
    {
        $userRepository = $manager->getRepository(User::class);
        $filesystem = new Filesystem();

        //creating visits in the database
        foreach ($this->getData() as [$name, $owner])
        {
            $visit = new Visit();
            $visit->setName($name);
            $visit->setOwner($userRepository->findOneBy(['username' => $owner]));

            $manager->persist($visit);
        }

        $manager->flush();

        //copying visits data (images, xml)
        foreach ($this->getData() as [$name])
        {
            $visitRepository = $manager->getRepository(Visit::class);
            $visit = $visitRepository->findOneBy(['name' => $name]);

            $filesystem->mirror(
                $this->root_dir.'/src/DataFixtures/VisitData/'.$name,
                $this->root_dir.'/public/visit/'.$visit->getId()
             );
        }
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
