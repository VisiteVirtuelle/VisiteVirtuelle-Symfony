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
            ),
            array(
                "name" => "agent",
                "password" => "agent",
                "email" => "agent@agent.agent",
                "role" => "ROLE_AGENT"
            ),
            array(
                "name" => "admin",
                "password" => "admin",
                "email" => "admin@admin.admin",
                "role" => "ROLE_ADMIN"
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