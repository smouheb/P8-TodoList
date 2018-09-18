<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction()
    {
        return $this->render('task/list.html.twig',
            ['tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')->findAll()]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $user = $this->getUser();

        $task->setUser($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task)
    {
        //Id of the current user
        $usr = $this->get('security.token_storage')
                    ->getToken()
                    ->getUser()
                    ->getId();

        //Id of the user who created the related task
        $iduser = $task->getUser()
                       ->getId();

        //Assign the Id of the anonyme user in  "user" table
        $anonymuser = 2;

        //Test first whether the task related user is linked to anonyme user
        if($iduser == $anonymuser){

            //Test whether the user has the right role to delete that task
            if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
            {
                $em = $this->getDoctrine()->getManager();
                $em->remove($task);
                $em->flush();

                $this->addFlash('success', 'La tâche a bien été supprimée.');

                return $this->redirectToRoute('task_list');
            }
            //When the user is not an admin and is trying to delete the task linked to an anonym user then he is redirected with an error
            $this->addFlash('error', sprintf('La tâche %s ne peut être supprimée que part un Administrateur', $task->getTitle()));

            return $this->redirectToRoute('task_list');

            //Test if the current user is the user who created that task that is trying to delete
        } elseif($usr == $iduser){

            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été supprimée.');

            return $this->redirectToRoute('task_list');

        }
        //added as part of the control implementation
        $this->addFlash('error', sprintf('La tâche %s ne peut être supprimée que part le user qui l\' a crée.', $task->getTitle()));

        return $this->redirectToRoute('task_list');

    }
}
