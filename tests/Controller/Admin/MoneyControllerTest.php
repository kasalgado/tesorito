<?php declare (strict_types=1);

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class MoneyControllerTest extends WebTestCase
{
    public function testCanGetStatusCodeFound()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/money/create');
        
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
    }
}
