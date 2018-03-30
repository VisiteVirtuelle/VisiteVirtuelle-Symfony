<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Guillaume Vidal <guillaume.vidal@gmail.com>
 *
 */

namespace App\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class LoginListener
{
    protected $doctrine;
    
    public function __construct(EntityManager $doctrine){
        $this->doctrine = $doctrine;
    }
    
    public function onSuccessfulLogin(AuthenticationEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        
        if($user instanceof AdvancedUserInterface)
        {
            $user->updateLastLogin();
            $this->doctrine->getManager()->persist($user);
            $this->doctrine->getManager()->flush();
        }
    }
}