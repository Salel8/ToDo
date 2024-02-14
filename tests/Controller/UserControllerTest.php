<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HTTPFoundation\Response;
use Symfony\Component\HTTPFoundation\Request;
use App\Entity\User;
use App\Repository\UserRepository;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp() : void
    {
        $this->client = static::createClient();

        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);

        $this->user = $this->userRepository->findOneByEmail('admin1@hotmail.fr');

        $this->urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->loginUser($this->user);
    }



    public function testListUser()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_list'));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }



    public function testCreateUser()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_create'));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }


    
    public function testValideCreateUser()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_create'));
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'John2';
        $form['user[password][first]'] = 'loup';
        $form['user[password][second]'] = 'loup';
        $form['user[email]'] = 'john2@hotmail.fr';
        $form['user[role]']->select('ROLE_USER');
        $this->client->submit($form);
        
        $crawler = $this->client->followRedirect();
          
        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');

    }


    public function testEditUser()
    {
        $crawler = $this->client->request('GET', '/users/4/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorTextContains('h1', 'Modifier');
    }



    public function testEditWithWrongIdUser()
    {
        $crawler = $this->client->request('GET', '/users/100/edit');

        $this->assertResponseStatusCodeSame(404);
    }


    
    public function testValideEditUser()
    {
        $crawler = $this->client->request('GET', '/users/5/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'Samir';
        $form['user[password][first]'] = 'dragon';
        $form['user[password][second]'] = 'dragon';
        $form['user[email]'] = 'samir@hotmail.fr';
        $form['user[role]']->select('ROLE_ADMIN');
        $this->client->submit($form);

        
        $crawler = $this->client->followRedirect();
          
        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');

    }



    public function testListWithUserRoleUser()
    {
        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $this->user = $this->userRepository->findOneByEmail('user1@hotmail.fr');
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->loginUser($this->user);
        $crawler = $this->client->request('GET', '/users');

        $this->assertResponseStatusCodeSame(403);
    }

    public function testCreateWithUserRoleUser()
    {
        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $this->user = $this->userRepository->findOneByEmail('user1@hotmail.fr');
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->loginUser($this->user);
        $crawler = $this->client->request('GET', '/users/create');

        $this->assertResponseStatusCodeSame(403);
    }

    public function testEditWithUserRoleUser()
    {
        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $this->user = $this->userRepository->findOneByEmail('user1@hotmail.fr');
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->loginUser($this->user);
        $crawler = $this->client->request('GET', '/users/1/edit');

        $this->assertResponseStatusCodeSame(403);
    }

}