<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testCheckPassword()
    {
        $client = static::createClient();
        
        $crawler = $client->request(
            'GET',
            '/en/register'
            );
        
        $form = $crawler->selectButton('Submit')->form();
        
        $form['user[email]'] = 'test@check.password';
        $form['user[username]'] = 'testCheckPassword';
        $form['user[password][first]'] = 'pass1';
        $form['user[password][second]'] = 'pass2';
        
        $crawler = $client->submit($form);
        
        $this->assertEquals(1,
            $crawler->filter('.invalid-feedback:contains("This value is not valid.")')->count()
        );
        
        $this->assertEquals(1,
            $crawler->filter('.invalid-feedback:contains("This email is already use")')->count()
        );
        //This value is not a valid email address.
    }
}