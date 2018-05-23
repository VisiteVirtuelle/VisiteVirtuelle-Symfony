<?php

namespace App\Tests\Controller;

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

        $form = $crawler->selectButton('Register')->form();

        $form['user[email]'] = 'toto@email.com';
        $form['user[username]'] = 'usernametest';
        $form['user[fullname]'] = 'John Doe';
        $form['user[password][first]'] = 'pass1';
        $form['user[password][second]'] = 'pass2';

        $crawler = $client->submit($form);

        $this->assertEquals(1,
            $crawler->filter('li:contains("This value is not valid.")')->count()
        );
    }
}