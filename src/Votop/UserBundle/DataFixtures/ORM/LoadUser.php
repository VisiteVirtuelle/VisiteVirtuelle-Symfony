<?php

namespace Votop\UserBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUser extends Fixture implements ContainerAwareInterface
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
        
        $users = array(
			array(
                "name" => "admin",
                "password" => "admin",
                "email" => "admin@admin.admin",
                "role" => "ROLE_ADMIN"
            ),
			array(
                "name" => "agent",
                "password" => "agent",
                "email" => "agent@agent.agent",
                "role" => "ROLE_AGENT"
            ),
			array(
                "name" => "agent1",
                "password" => "agent1",
                "email" => "agent1@agent1.agent1",
                "role" => "ROLE_AGENT"
            ),
			array(
                "name" => "agent2",
                "password" => "agent2",
                "email" => "agent2@agent2.agent2",
                "role" => "ROLE_AGENT"
            ),
			array(
                "name" => "agent3",
                "password" => "agent3",
                "email" => "agent3@agent3.agent3",
                "role" => "ROLE_AGENT"
            ),
            array(
                "name" => "user",
                "password" => "user",
                "email" => "user@user.user",
                "role" => "ROLE_USER"
            ),
            array(
                "name" => "vincent",
                "password" => "vincent",
                "email" => "vincent.claveau@lycee-bourdelle.fr",
                "role" => "ROLE_USER"
            ),
            array(
                "name" => "guillaume",
                "password" => "guillaume",
                "email" => "guillaume.vidal@lycee-bourdelle.fr",
                "role" => "ROLE_USER"
            )
        );

        foreach ($users as $u) {
            $user = $userManager->createUser();

            $user->setUsername($u["name"]);
            $user->setEmail($u["email"]);
            $user->setPlainPassword($u["password"]);
            $user->setEnabled(true);
            $user->setRoles(array($u["role"]));

            $manager->persist($user);
        }

        $manager->flush();
    }
}