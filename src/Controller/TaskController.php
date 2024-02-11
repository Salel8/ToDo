<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use App\Entity\User;
use App\Form\UserType;


class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'task_list')]
    public function listAction(EntityManagerInterface $entityManager, Request $request): Response
    {
        /*$repository = $entityManager->getRepository(Task::class);
        $tasks = $repository->findAll();*/
        $tasks = $entityManager->getRepository(Task::class)->findAll();

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
        ]);
    }


    #[Route('/tasks/create', name: 'task_create')]
    public function createAction(Request $request, EntityManagerInterface $entityManager, NotifierInterface $notifier)
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            if($this->getUser()){
                $user = $this->getUser();

                $task->setAuthor($user->getUsername());
            }

            $entityManager->persist($task);
            $entityManager->flush();

            $notifier->send(new Notification('La tâche a été bien été ajoutée.', ['browser']));

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/tasks/{id}/edit', name: 'task_edit')]
    public function editAction(int $id, Request $request, EntityManagerInterface $entityManager, NotifierInterface $notifier)
    {
        $task_db = $entityManager->getRepository(Task::class)->find($id);

        if (!$task_db) {
            throw $this->createNotFoundException(
                'No task found for id '.$id
            );
        }

        $task = new Task();

        $task->setTitle($task_db->getTitle());
        $task->setContent($task_db->getContent());
        $task->setAuthor($task_db->getAuthor());        

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $task_db->setTitle($task->getTitle());
            $task_db->setContent($task->getContent());

            $entityManager->persist($task_db);
            $entityManager->flush();

            $notifier->send(new Notification('La tâche a bien été modifiée.', ['browser']));




            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(), 
            'task' => $task_db,
        ]);
    }



    
    #[Route('/tasks/{id}/toggle', name: 'task_toggle')]
    public function toggleTaskAction(int $id, Request $request, EntityManagerInterface $entityManager, NotifierInterface $notifier)
    {
        $task_db = $entityManager->getRepository(Task::class)->find($id);

        if (!$task_db) {
            throw $this->createNotFoundException(
                'No task found for id '.$id
            );
        }

        $task_db->toggle(!$task_db->isDone());

        $entityManager->persist($task_db);
        $entityManager->flush();

        $notifier->send(new Notification('La tâche a bien été marquée comme faite.', ['browser']));

        //$this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }


    
    #[Route('/tasks/{id}/delete', name: 'task_delete')]
    public function deleteTaskAction(int $id, Request $request, EntityManagerInterface $entityManager, NotifierInterface $notifier)
    {
        $task_db = $entityManager->getRepository(Task::class)->find($id);

        if (!$task_db) {
            throw $this->createNotFoundException(
                'No task found for id '.$id
            );
        }

        if($this->getUser()){
            $user = $this->getUser();

            if($user->getUsername()==$task_db->getAuthor() || ($task_db->getAuthor()=="anonyme" && $user->getRoles()==["ROLE_ADMIN"])){
                $entityManager->remove($task_db);
                $entityManager->flush();

                $notifier->send(new Notification('La tâche a bien été supprimée.', ['browser']));
            }

            /*if($task_db->getAuthor()=="anonyme" && $user-getRole()=="ROLE_ADMIN"){
                $entityManager->remove($task_db);
                $entityManager->flush();

                $notifier->send(new Notification('La tâche a bien été supprimée.', ['browser']));
            }*/

        }

        

        

        /*$em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');*/

        return $this->redirectToRoute('task_list');
    }

}