<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HTTPFoundation\Response;
use Symfony\Component\HTTPFoundation\Request;
//use Symfony\Component\BrowserKit\Request;
//use Symfony\Component\BrowserKit\Response;
use App\Entity\User;
use App\Repository\UserRepository;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp() : void
    {
        $this->client = static::createClient();

        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);

        // Mettre comme argument de la méthode FindOneByEmail

        // l'e-mail utilisé sur GitHub, ou regarder en base de données quel est l'e-mail renseigné.

        $this->user = $this->userRepository->findOneByEmail('admin1@hotmail.fr');

        $this->urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->loginUser($this->user);
    }

    /*public function testLoginSuccessWithAdminRole()
    {
        //$client = static::createClient();
        $userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        //$userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('admin1@hotmail.fr');

        return $client->loginUser($testUser);

        //$crawler = $client->request('GET', '/login');

        //$this->assertResponseIsSuccessful();

        //$userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        //$testUser = $userRepository->findOneByEmail('john.doe@example.com');

        // simulate $testUser being logged in
        //$client->loginUser($testUser);
    }*/


    /*public function testLoginSuccessWithUserRole()
    {
        //$client = static::createClient();
        $userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);

        $testUser = $userRepository->findOneByEmail('user1@hotmail.fr');

        return $client->loginUser($testUser);

        //$crawler = $client->request('GET', '/login');

        //$this->assertResponseStatusCodeSame(204);
    }*/


    /*public function testListUser()
    {
        $client = static::createClient();
        //$this->testLoginSuccessWithAdminRole();
        //$userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $userRepository = static::getContainer()->get(UserRepository::class);

        //$testUser = $userRepository->findOneByEmail('admin1@hotmail.fr');
        $testUser = $userRepository->findOneBy(['email' => 'admin1@hotmail.fr']);
        //$testUser = $userRepository->find(1);

        $client->loginUser($testUser, 'main');

        $crawler = $client->request('GET', '/users');
        //$client->xmlHttpRequest('GET', '/users', ['email' => 'admin1@hotmail.fr']);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');
    }*/

    /*public function testListUser1()
    {
        $client = static::createClient();
        //$userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        

        //$this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Liste des utilisateurs');


        $userRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin1@hotmail.fr');
        //$testUser = $userRepository->find(1);
        $urlGenerator = $client->getContainer()->get('router.default');
        //Authentification sur Symfony pour le test avec le user récupéré en base
        $client->loginUser($testUser);
          
        $client->request(Request::METHOD_GET, $urlGenerator->generate('user_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }*/

    public function testListUser2()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_list'));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }



    public function testCreateUser()
    {
        /*$client = static::createClient();
        $this->testLoginSuccessWithAdminRole();
        $crawler = $client->request('GET', '/users/create');*/

        //$this->assertResponseIsSuccessful();
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_create'));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        //$this->assertSelectorTextContains('h1', 'Créer un utilisateur');
    }


    // à revoir
    public function testValideCreateUser()
    {
        /*$client = static::createClient();
        $this->testLoginSuccessWithAdminRole();
        $crawler = $client->request('GET', '/users/create');*/

        /*$crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_create'));

        $form = $crawler->selectButton('Ajouter')->form([
            'user_username' => 'Samir',
            '_password_first' => 'loup',
            '_password_second' => 'loup',
            '_email' => 'samir@hotmail.fr',
            '_role' => 'ROLE_USER'
        ]);

        $this->client->submit($form);
        $this->assertResponseRedirects('/users');
        $this->client->followRedirect();
        $this->assertSelectorExists('.alert alert-success');*/


        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_create'));
        $form = $crawler->selectButton('Ajouter')->form();
        //$form['food[entitled]'] = 'Plat de pâtes';
        $form['user[username]'] = 'Samir';
        $form['user[password][first]'] = 'loup';
        $form['user[password][second]'] = 'loup';
        $form['user[email]'] = 'samir@hotmail.fr';
        $form['user[role]']->select('ROLE_USER');
        $this->client->submit($form);
        //$crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_list'));
        //$this->assertResponseRedirects('/users');
        $crawler = $this->client->followRedirects();
        // Attention à bien récupérer le crawler mis à jour

        //$crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_list'));
          
        //$this->assertSelectorTextContains('div.alert.alert-success','L\'utilisateur a bien été ajouté.');
        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');

    }


    // à revoir
    public function testInvalideCreateUser()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_create'));
        $form = $crawler->selectButton('Ajouter')->form();
        //$form['food[entitled]'] = 'Plat de pâtes';
        $form['user[username]'] = '';
        $form['user[password][first]'] = 'loup';
        $form['user[password][second]'] = 'loup';
        $form['user[email]'] = 'samir@hotmail.fr';
        $form['user[role]']->select('ROLE_USER');
        $this->client->submit($form);
        $this->client->followRedirects();

        //$this->assertSelectorTextContains('div.alert.alert-success','L\'utilisateur a bien été ajouté.');
        /*$client = static::createClient();
        $this->testLoginSuccessWithAdminRole();
        $crawler = $client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'username' => 'Samir',
            'password' => '',
            'email' => 'samir@hotmail.fr',
            'role' => 'ROLE_USER'
        ]);



        $client->submit($form);
        $this->assertResponseRedirects('/users/create');
        $client->followRedirect();*/
    }


    public function testEditUser()
    {
        /*$client = static::createClient();
        $this->testLoginSuccessWithAdminRole();*/
        $crawler = $this->client->request('GET', '/users/4/edit');

        //$this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_edit', ('id' = '5')));
        //$this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('/users/4/edit'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        //$this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Modifier');
    }



    public function testEditWithWrongIdUser()
    {
        //$client = static::createClient();
        //$this->testLoginSuccessWithAdminRole();
        $crawler = $this->client->request('GET', '/users/100/edit');

        $this->assertResponseStatusCodeSame(404);
    }


    // à revoir
    public function testValideEditUser()
    {
        //$client = static::createClient();
        //$this->testLoginSuccessWithAdminRole();
        $crawler = $this->client->request('GET', '/users/5/edit');

        /*$form = $crawler->selectButton('Modifier')->form([
            'username' => 'Samir',
            'password' => 'dragon',
            'email' => 'samir@hotmail.fr',
            'role' => 'ROLE_ADMIN'
        ]);*/

        $form = $crawler->selectButton('Modifier')->form();
        //$form['food[entitled]'] = 'Plat de pâtes';
        $form['user[username]'] = 'Samir';
        $form['user[password][first]'] = 'dragon';
        $form['user[password][second]'] = 'dragon';
        $form['user[email]'] = 'samir@hotmail.fr';
        $form['user[role]']->select('ROLE_ADMIN');
        $this->client->submit($form);

        
        $this->client->followRedirects();
        //$this->assertResponseRedirects('/users');
        //$this->assertSelectorExists('.alert alert-success');

        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_list'));
          
        //$this->assertSelectorTextContains('div.alert.alert-success','L\'utilisateur a bien été ajouté.');
        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');

    }

    


    // à revoir
    public function testInvalideEditUser()
    {
        //$client = static::createClient();
        //$this->testLoginSuccessWithAdminRole();
        $crawler = $this->client->request('GET', '/users/5/edit');

        $form = $crawler->selectButton('Modifier')->form();
        //$form['food[entitled]'] = 'Plat de pâtes';
        $form['user[username]'] = 'Samir';
        $form['user[password][first]'] = 'dragon';
        $form['user[password][second]'] = 'dragon';
        $form['user[email]'] = 'samir@hotmail.fr';
        $form['user[role]']->select('ROLE_ADMIN');
        $this->client->submit($form);


        $this->client->followRedirects();
        //$this->assertResponseRedirects('/users/create');
        //$crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_list'));
        //$this->assertSelectorTextContains('h1', 'Modifier');
        
    }



    public function testListWithUserRoleUser()
    {
        //$client = static::createClient();
        //$this->testLoginSuccessWithUserRole();
        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $this->user = $this->userRepository->findOneByEmail('user1@hotmail.fr');
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->loginUser($this->user);
        $crawler = $this->client->request('GET', '/users');

        $this->assertResponseStatusCodeSame(403);
        //$this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Liste des utilisateurs');
    }

    public function testCreateWithUserRoleUser()
    {
        //$client = static::createClient();
        //$this->testLoginSuccessWithUserRole();
        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $this->user = $this->userRepository->findOneByEmail('user1@hotmail.fr');
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->loginUser($this->user);
        $crawler = $this->client->request('GET', '/users/create');

        $this->assertResponseStatusCodeSame(403);
        //$this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Créer un utilisateur');
    }

    public function testEditWithUserRoleUser()
    {
        //$client = static::createClient();
        //$this->testLoginSuccessWithUserRole();
        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $this->user = $this->userRepository->findOneByEmail('user1@hotmail.fr');
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->loginUser($this->user);
        $crawler = $this->client->request('GET', '/users/1/edit');

        $this->assertResponseStatusCodeSame(403);
        //$this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Modifier');
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