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

        /*$this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);

        // Mettre comme argument de la méthode FindOneByEmail

        // l'e-mail utilisé sur GitHub, ou regarder en base de données quel est l'e-mail renseigné.

        $this->user = $this->userRepository->findOneByEmail('admin1@hotmail.fr');

        $this->urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->loginUser($this->user);*/
    }
    /*public function testLoginSuccess()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        //$userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('mehal.samir@hotmail.fr');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        //$this->assertResponseRedirects('/users/create');
        //$client->followRedirect();
        //$this->assertSelectorTextContains('h1', 'Welcome to Symfony');


        ////
        /*$userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('<utiliser le mail de github comme expliqué dans le readme>');
        $urlGenerator = $this->client->getContainer()->get('router.default');
        //Authentification sur Symfony pour le test avec le user récupéré en base
        $this->client->loginUser($testUser);
          
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('homepage'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);*/
    //}


    /*public function testLoginFail()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        //$userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('sam77@hotmail.fr');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(204);
        //$this->assertResponseIsSuccessful();
        //$this->assertResponseRedirects('/users/create');
        //$client->followRedirect();
        //$this->assertSelectorTextContains('h1', 'Welcome to Symfony');
    }*/


    /*public function testLoginSuccess1()
    {
        $client = static::createClient();
        //$userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);

        //$testUser = $userRepository->findOneByEmail('sam77@hotmail.fr');

        //$client->loginUser($testUser);

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Admin1',
            '_password' => 'dragon'
        ]);

        //$this->assertResponseStatusCodeSame(204);
        $this->assertResponseIsSuccessful();
        //$this->assertResponseRedirects('/users/create');
        //$client->followRedirect();
        //$this->assertSelectorTextContains('h1', 'Welcome to Symfony');
    }*/


    /*public function testLoginFail1()
    {
        $client = static::createClient();
        //$userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);

        //$testUser = $userRepository->findOneByEmail('sam77@hotmail.fr');

        //$client->loginUser($testUser);

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Admin1',
            '_password' => 'dragons'
        ]);

        //$this->assertResponseStatusCodeSame(204);
        $this->assertResponseIsSuccessful();
        //$this->assertSelectorExists("div[class='.alert.alert-danger']");
        //$this->assertSelectorExists('.alert.alert-danger');
        //$this->assertResponseRedirects('/users/create');
        $client->followRedirects();
        //$this->assertSelectorTextContains('.alert.alert-danger', 'Invalid credentials.');
        //$this->assertSelectorTextContains("div[class='.alert.alert-danger']", 'Invalid credentials.');
        $this->assertSelectorTextContains('div.alert.alert-danger','Invalid credentials.');
    }*/

    public function testLoginSuccess2()
    {
        //$client = static::createClient();
        //$userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);

        //$testUser = $userRepository->findOneByEmail('sam77@hotmail.fr');

        //$client->loginUser($testUser);

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Admin1',
            '_password' => 'dragon'
        ]);

        $this->client->submit($form);
        $this->client->followRedirect();

        //$this->assertResponseStatusCodeSame(204);
        $this->assertResponseIsSuccessful();
        //$this->assertResponseRedirects('/users/create');
        //$client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !');
    }

    public function testLoginFail2()
    {
        

        /*$crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Admin1',
            '_password' => 'dragons'
        ]);

        //$this->assertResponseStatusCodeSame(204);
        $this->assertResponseIsSuccessful();
        //$this->assertSelectorExists("div[class='.alert.alert-danger']");
        //$this->assertSelectorExists('.alert.alert-danger');
        //$this->assertResponseRedirects('/users/create');
        $client->followRedirects();
        //$this->assertSelectorTextContains('.alert.alert-danger', 'Invalid credentials.');
        //$this->assertSelectorTextContains("div[class='.alert.alert-danger']", 'Invalid credentials.');
        $this->assertSelectorTextContains('div.alert.alert-danger','Invalid credentials.');*/

        //$crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('login'));
        /*$form = $crawler->selectButton('Se connecter')->form();
        $form['food[entitled]'] = 'Plat de pâtes';
        $form['food[calories]'] = 600;*/
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Admin1',
            '_password' => 'dragons'
        ]);
        $this->client->submit($form);
        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-danger','Invalid credentials.');
    }

}