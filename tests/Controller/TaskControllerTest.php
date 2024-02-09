<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HTTPFoundation\Response;
use Symfony\Component\HTTPFoundation\Request;

class TaskControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp() : void
    {
        $this->client = static::createClient();
    }

    public function testListTask()
    {
        //$client = static::createClient();
        $crawler = $this->client->request('GET', '/tasks');

        $this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Liste des utilisateurs');
        $this->assertSelectorExists('.slide-image');
    }



    public function testCreateTask()
    {
        //$client = static::createClient();
        $crawler = $this->client->request('GET', '/tasks/create');

        $this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Créer un utilisateur');
        $this->assertSelectorExists('.pull-right');
    }



    //public function testValidCreateTask()
    //{
        /*$client = static::createClient();
        $crawler = $client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'task_title' => 'Un titre',
            'task_content' => 'Ceci est du contenu',
            'task_author' => 'admin1@hotmail.fr'
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert-success');*/

        //$client = static::createClient();
        /*$this->client->request('GET', '/tasks/create');

        $crawler = $this->client->submitForm('Ajouter', [
            'task[title]' => 'Un titre',
            'task[content]' => 'Ceci est du contenu',
            'task[author]' => 'admin1@hotmail.fr'
        ]);
        $this->client->submit($form);
        //$this->client->followRedirect();
        $this->assertResponseRedirects('/tasks');
        
        //$this->assertSelectorExists('.alert-success');*/
    //}

    public function testValidCreateTask2()
    {
        /*$client = static::createClient();
        $crawler = $client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'task_title' => 'Un titre',
            'task_content' => 'Ceci est du contenu',
            'task_author' => 'admin1@hotmail.fr'
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert-success');*/

        //$client = static::createClient();
        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Un titre';
        $form['task[content]'] = 'Ceci est du contenu';
        $form['task[author]'] = 'admin1@hotmail.fr';
        $this->client->submit($form);

        $this->client->followRedirect();

        $this->assertSelectorExists('.slide-image');

        /*$form = $this->client->submitForm('Ajouter', [
            'task[title]' => 'Un titre',
            'task[content]' => 'Ceci est du contenu',
            'task[author]' => 'admin1@hotmail.fr'
        ]);
        $this->client->submit($form);*/
        //$this->client->followRedirect();
        //$this->assertResponseRedirects('/tasks');
        
        //$this->assertSelectorExists('.alert-success');
    }



    public function testInvalidCreateTask()
    {
        //$client = static::createClient();
        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = '';
        $form['task[content]'] = 'Ceci est du contenu';
        $form['task[author]'] = 'admin1@hotmail.fr';
        $this->client->submit($form);

        $this->assertSelectorTextContains('div.alert.alert-danger','Invalid credentials.');

        // on ne peut pas appuyer sur le bouton submit s'il manque un champ

        //$this->client->followRedirect();

        /*$crawler = $client->submitForm('Ajouter', [
            'task[title]' => '',
            'task[content]' => 'Ceci est du contenu',
            'task[author]' => 'admin1@hotmail.fr'
        ]);*/

        //$this->assertSelectorExists('.alert.alert-danger');
        //$this->assertResponseRedirects('/tasks/create');
        //$client->followRedirect();
    }


    public function testEditTask()
    {
        //$client = static::createClient();
        $crawler = $this->client->request('GET', '/tasks/16/edit');

        $this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Modifier');
    }



    public function testEditWithWrongIdTask()
    {
        //$client = static::createClient();
        $crawler = $this->client->request('GET', '/tasks/100/edit');

        $this->assertResponseStatusCodeSame(404);
    }


    public function testValideEditTask()
    {
        //$client = static::createClient();
        $crawler = $this->client->request('GET', '/tasks/3/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Un titre modifié';
        $form['task[content]'] = 'Ceci est du contenu modifié';
        //$form['task[author]'] = 'admin1@hotmail.fr';
        $this->client->submit($form);

        $this->client->followRedirect();

        $this->assertSelectorExists('.slide-image');

        /*$form = $crawler->selectButton('Modifier')->form([
            'title' => 'Un titre modifié',
            'content' => 'Ceci est du contenu modifié'
        ]);

        $client->submit($form);*/
        /*$this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert-success');*/
    }



    public function testInvalideEditTask()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'title' => '',
            'content' => 'Ceci est du contenu modifié'
        ]);



        $client->submit($form);
        $this->assertResponseRedirects('/tasks/edit');
        $client->followRedirect();
    }


    public function testToggleTask()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/3/toggle');

        //$this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Modifier');
        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert-success');
    }



    public function testToggleWithWrongIdTask()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/100/toggle');

        $this->assertResponseStatusCodeSame(404);
    }


    public function testDeleteTask()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin1@hotmail.fr');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/tasks/4/delete');

        //$this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Modifier');
        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert-success');
    }



    public function testDeleteWithWrongIdTask()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/100/delete');

        $this->assertResponseStatusCodeSame(404);
    }


    public function testDeleteWithWrongUserTask()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('user1@hotmail.fr');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/tasks/1/delete');

        $this->assertResponseStatusCodeSame(403);

        //$this->assertResponseRedirects('/tasks');
        //$client->followRedirect();
        //$this->assertSelectorExists('.alert-success');
    }

    public function testDeleteAnonymeWithRoleAdminTask()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin1@hotmail.fr');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/tasks/4/delete');

        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert-success');
    }

}