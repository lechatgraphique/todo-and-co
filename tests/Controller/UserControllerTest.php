<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testListActionWithoutLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/users');
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        static::assertSame(1, $crawler->filter('input[name="_username"]')->count());
        static::assertSame(1, $crawler->filter('input[name="_password"]')->count());
    }

    public function testListAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginAsAdmin();

        $client->request('GET', '/users');
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testEditAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginAsAdmin();

        $crawler = $client->request('GET', '/users/1/edit');
        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame(1, $crawler->filter('input[name="user[username]"]')->count());
        static::assertSame(1, $crawler->filter('input[name="user[password][first]"]')->count());
        static::assertSame(1, $crawler->filter('input[name="user[password][second]"]')->count());
        static::assertSame(1, $crawler->filter('input[name="user[email]"]')->count());

        static::assertSame(2, $crawler->filter('select[name="user[roles]"] > option')->count());

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'admin1';
        $form['user[password][first]'] = '12345';
        $form['user[password][second]'] = '12345';
        $form['user[email]'] = 'editadmin1@gmail.com';
        $form['user[roles]'];

        $client->submit($form);
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginAsAdmin();

        $crawler = $client->request('GET', '/users/create');
        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame(1, $crawler->filter('input[name="user[username]"]')->count());
        static::assertSame(1, $crawler->filter('input[name="user[password][first]"]')->count());
        static::assertSame(1, $crawler->filter('input[name="user[password][second]"]')->count());
        static::assertSame(1, $crawler->filter('input[name="user[email]"]')->count());
        static::assertSame(2, $crawler->filter('select[name="user[roles]"] > option')->count());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'newuser';
        $form['user[password][first]'] = '12345';
        $form['user[password][second]'] = '12345';
        $form['user[email]'] = 'newuser@gmail.com';
        $form['user[roles]'];

        $client->submit($form);
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }
}
