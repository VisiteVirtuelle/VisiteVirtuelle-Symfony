<?php

/* 
 * This file is part of the Virtual Visit application. 
 * 
 * Vincent Claveau <vinc.claveau@gmail.com> 
 * 
 */ 
 
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as [$fullname, $username, $password, $email, $roles])
        {
            $user = new User();
            $user->setFullName($fullname);
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);
            
            $manager->persist($user);
        }
        
        $manager->flush();
    }
    
    private function getData(): array
    {
        return [
            // $userData = [$fullname, $username, $password, $email, $roles];
            
            ['Admin', 'admin', 'admin', 'admin@admin.admin', ['ROLE_ADMIN']],
            ['Agent', 'agent', 'agent', 'agent@agent.agent', ['ROLE_AGENT']],
            ['User', 'user', 'user', 'user@user.user', ['ROLE_USER']],
            
            ['Agent 1', 'agent1', 'agent1', 'agent1@agent1.agent1', ['ROLE_AGENT']],
            ['Agent 2', 'agent2', 'agent2', 'agent2@agent2.agent2', ['ROLE_AGENT']],
            ['Agent 3', 'agent3', 'agent3', 'agent3@agent3.agent3', ['ROLE_AGENT']],
            
            ['Vincent Claveau', 'Votop', 'Votop', 'vincent.claveau@lycee-bourdelle.fr', ['ROLE_AGENT']],
            ['Guillaume Vidal', 'guiguiz', 'guiguiz', 'guillaume.vidal@lycee-bourdelle.fr', ['ROLE_AGENT']],
            ['Valentin Pillon', 'Pillon', 'Pillon', 'valentin.pillon@lycee-bourdelle.fr', ['ROLE_AGENT']],
            ['Thomas Duditlieux', 'Tao999', 'Tao999', 'thomas.duditlieux@lycee-bourdelle.fr', ['ROLE_AGENT']],
            ['Malko Carreras', 'YeTskyan', 'YeTskyan', 'malko.carreras@lycee-bourdelle.fr', ['ROLE_AGENT']],
        ];
    }
}