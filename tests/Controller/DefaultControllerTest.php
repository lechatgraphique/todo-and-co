<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexActionWithoutLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        static::assertSame(1, $crawler->filter('input[name="_username"]')->count());
        static::assertSame(1, $crawler->filter('input[name="_password"]')->count());
    }
}
