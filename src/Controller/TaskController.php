<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Form\Type\TaskType;
use App\Entity\Task;
use App\Service\Observer;
use App\Service\DataCache;
use App\Repository\TaskRepository;

class TaskController extends AbstractController
{
    /**
     * @Route("/task/create", name="_task_create")
     * @Route("/task/edit", name="_task_edit")
     * @Template()
     */
    public function create(Request $request, Observer $observer, EntityManagerInterface $em)
    {
        $id = $request->get('id');
        $task = $id ? $this->repository()->find($id) : new Task();
        
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if ($id) {
                $task->setCompleted(false);
            }

            $em->persist($task);
            $em->flush();
            
            $observer->update('task');

            if ($request->get('new_task') === '1') {
                return $this->redirect($this->generateUrl('_task_create'));
            }
            
            return $this->redirect($this->generateUrl('_admin_panel'));
        }
        
        return [
            'form' => $form->createView(),
            'id' => $id,
        ];
    }
    
    /**
     * @Route("/task/delete/{id}", name="_task_delete", requirements={"id"="\d+"})
     */
    public function delete(int $id, Observer $observer, EntityManagerInterface $em)
    {
        $post = $this->repository()->find($id);
        $em->remove($post);
        $em->flush();
        
        $observer->update('task');

        return $this->redirect($this->generateUrl('_admin_panel'));
    }
    
    /**
     * @Route("/task/list", name="_task_list", methods={"POST"})
     * @Template("/task/default.html.twig")
     */
    public function list(DataCache $cache): array
    {
        $tasks = $this->repository()->findByDate();
        
        return [
            'tasks' => $cache->get($tasks, 'task'),
        ];
    }
    
    /**
     * @Route("/task/completed/{id}", name="_task_completed", requirements={"id"="\d+"}, methods={"POST"})
     * @Template("/task/default.html.twig")
     */
    public function completed(int $id, Observer $observer, EntityManagerInterface $em): array
    {
        $task = $this->repository()->find($id)->setCompleted(true);
        $em->persist($task);
        $em->flush();

        $observer->update('task');

        return ['tasks' => $this->repository()->findByDate()];
    }

	/**
	 * @Route("/task/today/{id}", name="_task_today", requirements={"id"="\d+"})
	 */
    public function setToday(int $id, Observer $observer, EntityManagerInterface $em)
    {
        $today = new \DateTime('now');
        $task = $this->repository()->find($id);
        $task->setCompleted(false);
        $task->setOnDay($today);

        $em->persist($task);
        $em->flush();

        $observer->update('task');

        return $this->redirect($this->generateUrl('_admin_panel'));
    }
    
    private function repository(): TaskRepository
    {
        return $this->getDoctrine()->getRepository(Task::class);
    }
}
