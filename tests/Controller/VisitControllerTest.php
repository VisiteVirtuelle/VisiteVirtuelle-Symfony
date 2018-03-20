<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Entity\Visit;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VisittControllerTest extends WebTestCase
{
    public function testCheckPassword(){
        $user = new User();
        $user->setFullName("John Doe");
        $user->setUsername("john");
        $user->setPassword($this->passwordEncoder->encodePassword($user, "password"));
        $user->setEmail("john@test.com");
        $user->setRoles(["ROLE_USER"]);

        $vist = new Visit();
        $visit->setName("Test visit");
        $visit->setOwner($user);
    }
}
