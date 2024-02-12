<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');
    }



    public function testCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/create');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Créer un utilisateur');
    }



    public function testValideCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'username' => 'Sam',
            'password' => 'dragon',
            'email' => 'sam-77@hotmail.fr'
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/users');
        $client->followRedirect();
        $this->assertSelectorExists('.alert alert-success');

    }



    public function testInvalideCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'username' => 'Sam',
            'password' => 'loup',
            'email' => 'sam-77@hotmail.fr',
        ]);



        $client->submit($form);
        $this->assertResponseRedirects('/users/create');
        $client->followRedirect();
    }


    public function testEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/1/edit');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Modifier');
    }



    public function testEditWithWrongId()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/100/edit');

        $this->assertResponseStatusCodeSame(404);
    }



    public function testValideEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'username' => 'Sam',
            'password' => 'Dragon',
            'email' => 'sam-77@hotmail.fr'
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/users');
        $client->followRedirect();
        $this->assertSelectorExists('.alert alert-success');

    }



    public function testInvalideEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'username' => 'Sam',
            'password' => 'loup',
            'email' => 'sam-77@hotmail.fr',
        ]);



        $client->submit($form);
        $this->assertResponseRedirects('/users/create');
        $client->followRedirect();
    }

    //use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
    //use Symfony\Component\Security\Core\Exception\AccessDeniedException;
    /*public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }*/
    //if (false === $this->authorizationChecker->isGranted('ROLE_NEWSLETTER_ADMIN')) { .... etc
    //throw new AccessDeniedException()
}