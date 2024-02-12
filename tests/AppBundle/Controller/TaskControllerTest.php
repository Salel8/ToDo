<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks');

        $this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Liste des utilisateurs');
        $this->assertSelectorExists('.slide-image');
    }



    public function testCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/create');

        $this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Créer un utilisateur');
        $this->assertSelectorExists('.pull-right');
    }



    public function testValideCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'title' => 'Un titre',
            'content' => 'Ceci est du contenu'
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert-success');
    }



    public function testInvalideCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'title' => '',
            'content' => 'Ceci est du contenu'
        ]);



        $client->submit($form);
        $this->assertResponseRedirects('/tasks/create');
        $client->followRedirect();
    }


    public function testEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/1/edit');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Modifier');
    }



    public function testEditWithWrongId()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/100/edit');

        $this->assertResponseStatusCodeSame(404);
    }


    public function testValideEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'title' => 'Un titre',
            'content' => 'Ceci est du contenu'
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert-success');
    }



    public function testInvalideEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'title' => '',
            'content' => 'Ceci est du contenu'
        ]);



        $client->submit($form);
        $this->assertResponseRedirects('/tasks/edit');
        $client->followRedirect();
    }


    public function testToggle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/1/toggle');

        //$this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Modifier');
        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert-success');
    }



    public function testToggleWithWrongId()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/100/toggle');

        $this->assertResponseStatusCodeSame(404);
    }


    public function testDelete()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/1/delete');

        //$this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Modifier');
        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert-success');
    }



    public function testDeleteWithWrongId()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/100/delete');

        $this->assertResponseStatusCodeSame(404);
    }

}