<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testListActionWithoutLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks');
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame(1, $crawler->filter('input[name="_username"]')->count());
        static::assertSame(1, $crawler->filter('input[name="_password"]')->count());
    }

    public function testListAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLogin();

        $client->request('GET', '/tasks');
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLogin();

        $crawler = $client->request('GET', '/tasks/create');
        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame(1, $crawler->filter('input[name="task[title]"]')->count());
        static::assertSame(1, $crawler->filter('textarea[name="task[content]"]')->count());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Nouvelle tâche';
        $form['task[content]'] = 'Ceci est une tâche crée par un test';
        $client->submit($form);
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testEditAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLogin();

        $crawler = $client->request('GET', '/tasks/2/edit');
        static::assertSame(200, $client->getResponse()->getStatusCode());
        static::assertSame(1, $crawler->filter('input[name="task[title]"]')->count());
        static::assertSame(1, $crawler->filter('textarea[name="task[content]"]')->count());

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Modification de tache';
        $form['task[content]'] = 'Je modifie une tache';
        $client->submit($form);
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteTaskAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLogin();

        $client->request('GET', '/tasks/2/delete');
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());

    }

    public function testDeleteTaskActionWhereSimpleUserIsNotAuthor()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLogin();

        $client->request('GET', '/tasks/2/delete');
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteTaskActionWithSimpleUserWhereAuthorIsAnonymous()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLogin();

        $client->request('GET', '/tasks/2/delete');
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteTaskActionWhereItemDontExists()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLogin();

        $client->request('GET', '/tasks/-100/delete');
        static::assertSame(404, $client->getResponse()->getStatusCode());
    }

    public function testToggleTaskAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLogin();

        $crawler = $client->request('GET', '/tasks');

        $form = $crawler->selectButton('Marquer comme faite')->last()->form();
        $client->submit($form);

        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }
}
