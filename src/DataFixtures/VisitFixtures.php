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
    private $project_dir;

    public function __construct(string $project_dir)
    {
        $this->project_dir = $project_dir;
    }

    public function load(ObjectManager $manager)
    {
        $userRepository = $manager->getRepository(User::class);

        //creating visits in the database
        foreach ($this->getData() as [$name, $owner, $location])
        {
            $visit = new Visit();
            $visit->setName($name);
            $visit->setOwner($userRepository->findOneBy(['username' => $owner]));
            $visit->setLocation($location);
            $visit->setSqft(mt_rand(50, 2000));
            $visit->setPrice(mt_rand(50000, 5000000));

            $manager->persist($visit);
        }
        $manager->flush();

        //copying visits data (images, xml)
        $filesystem = new Filesystem();
        foreach ($this->getData() as [$name])
        {
            $visitRepository = $manager->getRepository(Visit::class);
            $visit = $visitRepository->findOneBy(['name' => $name]);

            $filesystem->mirror(
                $this->project_dir.'/src/DataFixtures/VisitData/'.$name,
                $this->project_dir.'/public/visit/'.$visit->getId()
             );
        }
    }

    private function getData(): array
    {
        return [
            // $visitData = [$name, $owner, $location];
            ['Antoine Bourdelle', 'Pillon', 'Montauban'],
            ['Mountains', 'Votop', 'World'],
            ['Canyons', 'Votop', 'USA'],
            ['Islands', 'Votop', 'World'],
            ['Paris', 'guiguiz', 'Paris'],
            ['Bangkok', 'guiguiz', 'Thaïland'],
            ['UFO', 'agent', 'Taïwan'],
            ['Misc', 'Pillon', 'Somewhere'],
            ['Buddha', 'Tao999', 'Asia'],
            ['Soudan', 'YeTskyan', 'Africa']
        ];
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
