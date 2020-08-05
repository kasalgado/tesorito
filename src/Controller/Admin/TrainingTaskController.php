<?php

namespace App\Controller\Admin;

use App\Entity\TrainingTask;
use App\Form\Admin\TrainingTaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrainingTaskController extends AbstractController
{
    /**
     * @Route("/training/task/create", name="_admin_training_task_create")
     * @Route("training/task/edit", name="_admin_training_task_edit")
     * @Template()
     */
    public function create(Request $request)
    {
        $id = $request->get('id');
        $task = $id ? $this->repository()->find($id) : new TrainingTask();
        $form = $this->createForm(TrainingTaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect($this->generateUrl('_admin_panel'));
        }

        return [
            'form' => $form->createView(),
            'id' => $id,
        ];
    }

    private function repository()
    {
        return $this->getDoctrine()->getRepository(TrainingTask::class);
    }
}