<?php

namespace App\Tests\Controller;

use App\Controller\SecurityController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        static::assertSame(200, $client->getResponse()->getStatusCode());
        
        static::assertSame(1, $crawler->filter('input[name="_username"]')->count());
        static::assertSame(1, $crawler->filter('input[name="_password"]')->count());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'user3';
        $form['_password'] = '12345';
        $client->submit($form);

        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());

        return $client;
    }

    public function testLoginAsAdmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame(1, $crawler->filter('input[name="_username"]')->count());
        static::assertSame(1, $crawler->filter('input[name="_password"]')->count());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'admin1';
        $form['_password'] = '12345';
        $client->submit($form);

        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());

        return $client;
    }

    public function testLoginWithWrongCredentials()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame(1, $crawler->filter('input[name="_username"]')->count());
        static::assertSame(1, $crawler->filter('input[name="_password"]')->count());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'user';
        $form['_password'] = '1';
        $client->submit($form);

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame("Invalid credentials.", $crawler->filter('div.alert.alert-danger')->text());
    }

    public function testLoginCheck()
    {
        $securityController = new SecurityController();

        $check = $securityController->loginCheck();
        self::assertNull( $check );
    }

    public function testLogout()
    {
        $securityController = new SecurityController();

        $check = $securityController->logoutCheck();
        self::assertNull( $check );
    }
}
