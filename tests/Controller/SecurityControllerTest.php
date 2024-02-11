<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HTTPFoundation\Response;
use Symfony\Component\HTTPFoundation\Request;

class SecurityControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp() : void
    {
        $this->client = static::createClient();
    }
    

    public function testLoginSuccess()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Admin1',
            '_password' => 'dragon'
        ]);

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !');
    }

    public function testLoginFail()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Admin1',
            '_password' => 'dragons'
        ]);
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-danger','Invalid credentials.');
    }

}