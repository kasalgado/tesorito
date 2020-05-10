<?php declare (strict_types=1);

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DishControllerTest extends WebTestCase
{
    public function testCanGetStatusCodeFoundFromCreate()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/dish/create');
        
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
    }
    
    public function testCanGetStatusCodeFoundFromEdit()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/dish/edit');
        
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
    }
}
