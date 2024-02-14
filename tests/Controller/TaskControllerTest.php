<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HTTPFoundation\Response;
use Symfony\Component\HTTPFoundation\Request;
use App\Entity\User;
use App\Repository\UserRepository;

class TaskControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp() : void
    {
        $this->client = static::createClient();
    }

    public function testListTask()
    {
        $crawler = $this->client->request('GET', '/tasks');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.slide-image');
    }



    public function testCreateTask()
    {
        $crawler = $this->client->request('GET', '/tasks/create');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.pull-right');
    }

    public function testValidCreateTask2()
    {
        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Un titre';
        $form['task[content]'] = 'Ceci est du contenu';
        $form['task[author]'] = 'Admin1';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSelectorExists('.slide-image');
    }


    // à revoir
    /*public function testInvalidCreateTask()
    {
        /// à revoir car on ne peut pas appuyer sur submit
        //$client = static::createClient();
        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = '';
        $form['task[content]'] = 'Ceci est du contenu';
        $form['task[author]'] = 'admin1@hotmail.fr';
        $this->client->submit($form);

        $this->assertSelectorTextContains('div.alert.alert-danger','Invalid credentials.');

        // on ne peut pas appuyer sur le bouton submit s'il manque un champ

        
    }*/


    public function testEditTask()
    {
        $crawler = $this->client->request('GET', '/tasks/16/edit');

        $this->assertResponseIsSuccessful();
    }



    public function testEditWithWrongIdTask()
    {
        $crawler = $this->client->request('GET', '/tasks/100/edit');

        $this->assertResponseStatusCodeSame(404);
    }


    public function testValideEditTask()
    {
        $crawler = $this->client->request('GET', '/tasks/11/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Un titre modifié';
        $form['task[content]'] = 'Ceci est du contenu modifié';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSelectorExists('.slide-image');
    }


    // à revoir
    /*public function testInvalideEditTask()
    {

        /// à revoir car on ne peut pas appuyer sur submit
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'title' => '',
            'content' => 'Ceci est du contenu modifié'
        ]);



        $client->submit($form);
        $this->assertResponseRedirects('/tasks/edit');
        $client->followRedirect();
    }*/


    public function testToggleTask()
    {
        //$client = static::createClient();
        $crawler = $this->client->request('GET', '/tasks/11/toggle');

        $crawler = $this->client->followRedirect();
        
        $this->assertSelectorExists('.slide-image');
    }



    public function testToggleWithWrongIdTask()
    {
        $crawler = $this->client->request('GET', '/tasks/100/toggle');

        $this->assertResponseStatusCodeSame(404);
    }


    public function testDeleteTask()
    {
        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $this->user = $this->userRepository->findOneByEmail('admin1@hotmail.fr');
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->loginUser($this->user);
        
        $crawler = $this->client->request('GET', '/tasks/16/delete');

        $crawler = $this->client->followRedirect();
        $this->assertSelectorExists('.slide-image');
    }



    public function testDeleteWithWrongIdTask()
    {
        $crawler = $this->client->request('GET', '/tasks/100/delete');

        $this->assertResponseStatusCodeSame(404);
    }


    public function testDeleteWithWrongUserTask()
    {
        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $this->user = $this->userRepository->findOneByEmail('user1@hotmail.fr');
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->loginUser($this->user);
        
        $crawler = $this->client->request('GET', '/tasks/15/delete');

        $crawler = $this->client->followRedirects();

        $this->assertResponseStatusCodeSame(302);
        // Ce code de réponse indique que l'URI de la ressource demandée a été modifiée temporairement. 
        // De nouveaux changements dans l'URI pourront être effectués ultérieurement.
        // Par conséquent, cette même URI devrait être utilisée par le client pour les requêtes futures.
    }

    public function testDeleteAnonymeWithRoleAdminTask()
    {
        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $this->user = $this->userRepository->findOneByEmail('admin1@hotmail.fr');
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->loginUser($this->user);
        
        $crawler = $this->client->request('GET', '/tasks/33/delete');

        $crawler = $this->client->followRedirect();
        $this->assertSelectorExists('.slide-image');
    }

}