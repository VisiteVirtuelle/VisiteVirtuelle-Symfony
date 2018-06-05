<?php
/*
use App\Entity\User;
use App\Entity\Visit;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VisitControllerTest extends WebTestCase
{
    public function testVisitList()
    {
        $user = new User();
        $visit = new Visit();
        $visit->setName("Test visit");
        $visit->setOwner($user);

        $client = static::createClient();
        
        $crawler = $client->request(
            'GET',
            '/en/visit/list'
        );
        
        $this->assertEquals(1,
            $crawler->filter('.card:contains('.$visit->getName().')')->count()
        );
    }
    
    /*public function testVisitListEmpty()
    {
        
    }*/
//}
