<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        //$manager->flush();

        $utilisateur1 = new User;
        $utilisateur1->setUsername('Admin1');
        $utilisateur1->setPassword($this->userPasswordHasher->hashPassword($utilisateur1, "dragon"));
        $utilisateur1->setEmail('admin1@hotmail.fr');
        $utilisateur1->setRoles(['ROLE_ADMIN']);
        $manager->persist($utilisateur1);
        $manager->flush();

        $utilisateur2 = new User;
        $utilisateur2->setUsername('User1');
        $utilisateur2->setPassword($this->userPasswordHasher->hashPassword($utilisateur2, "tigre"));
        $utilisateur2->setEmail('user1@hotmail.fr');
        $utilisateur2->setRoles(['ROLE_USER']);
        $manager->persist($utilisateur2);
        $manager->flush();


        $tache1 = new Task;
        $tache1->setTitle('Titre 1');
        $tache1->setContent('Contenu 1');
        $tache1->setAuthor('admin1@hotmail.fr');
        $manager->persist($tache1);
        $manager->flush();

        $tache2 = new Task;
        $tache2->setTitle('Titre 2');
        $tache2->setContent('Contenu 2');
        $tache2->setAuthor('user1@hotmail.fr');
        $manager->persist($tache2);
        $manager->flush();

        $tache3 = new Task;
        $tache3->setTitle('Titre 3');
        $tache3->setContent('Contenu 3');
        $tache3->setAuthor('anonyme');
        $manager->persist($tache3);
        $manager->flush();
    }
}
