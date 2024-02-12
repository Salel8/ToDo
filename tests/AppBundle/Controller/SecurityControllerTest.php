<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginSuccess()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        //$userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('sam-77@hotmail.fr');

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
    }


    public function testLoginFail()
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
    }
}