<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN', message: 'You are not allowed to access the admin dashboard.')]
    #[Route('/users', name: 'user_list')]
    public function listAction(EntityManagerInterface $entityManager, Request $request): Response
    {
        $repository = $entityManager->getRepository(User::class);
        $users = $repository->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }


    #[IsGranted('ROLE_ADMIN', message: 'You are not allowed to access the admin dashboard.')]
    #[Route('/users/create', name: 'user_create')]
    public function createAction(Request $request, EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher, NotifierInterface $notifier)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $plaintextPassword = $user->getPassword();
            
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $user->setRoles([$user->getRole()]);

            $entityManager->persist($user);
            $entityManager->flush();

            $notifier->send(new Notification('L\'utilisateur a bien été ajouté.', ['browser']));

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[IsGranted('ROLE_ADMIN', message: 'You are not allowed to access the admin dashboard.')]
    #[Route('/users/{id}/edit', name: 'user_edit')]
    public function editAction(int $id, Request $request, EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher, NotifierInterface $notifier)
    {
        $user_db = $entityManager->getRepository(User::class)->find($id);

        if (!$user_db) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $user = new User();

        $user->setUsername($user_db->getUsername());
        $user->setEmail($user_db->getEmail());

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $plaintextPassword = $user->getPassword();

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user_db->setPassword($hashedPassword);
            $user_db->setUsername($user->getUsername());
            $user_db->setEmail($user->getEmail());
            $user_db->setRoles([$form->get('role')->getData()]);


            $entityManager->persist($user_db);
            $entityManager->flush();

            $notifier->send(new Notification('L\'utilisateur a bien été modifié.', ['browser']));

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(), 
            'user' => $user_db,
        ]);
    }
}