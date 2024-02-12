<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function listAction(EntityManagerInterface $entityManager, Request $request): Response
    {
        $repository = $entityManager->getRepository(User::class);
        $users = $repository->findAll();

        return $this->render('user/list.html.twig', [
            //'users' => $this->getDoctrine()->getRepository('AppBundle:User')->findAll()
            'users' => $users,
        ]);
    }


    
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

            $entityManager->persist($user);
            $entityManager->flush();

            $notifier->send(new Notification('Vous avez modifié votre article.', ['browser']));

            return $this->redirectToRoute('user_list');
        }
        //$user = new User();
        //$form = $this->createForm(UserType::class, $user);

        //$form->handleRequest($request);

        /*if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }*/

        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/users/{id}/edit', name: 'user_edit')]
    public function editAction(int $id, Request $request, EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher, NotifierInterface $notifier)
    {
        $user_db = $entityManager->getRepository(User::class)->find($id);

        if (!$user_db) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        //$post_db = $entityManager->getRepository(Post::class)->findOneBy(['id' => $id]);

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
            $user_db->setPassword($hashedPassword);

            $entityManager->persist($user_db);
            $entityManager->flush();

            $notifier->send(new Notification('L\'utilisateur a bien été modifié.', ['browser']));

            //$password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            //$user->setPassword($password);

            //$this->getDoctrine()->getManager()->flush();

            //$this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(), 
            'user' => $user,
        ]);
    }
}