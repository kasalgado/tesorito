<?php

namespace App\Controller\Admin;

use App\Entity\Training;
use App\Form\Admin\TrainingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController
{
    /**
     * @Route("/training/create", name="_admin_training_create")
     * @Route("training/edit", name="_admin_training_edit")
     * @Template()
     */
    public function create(Request $request)
    {
        $id = $request->get('id');
        $training = $id ? $this->repository()->find($id) : new Training();
        $form = $this->createForm(TrainingType::class, $training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($training);
            $em->flush();

            return $this->redirect($this->generateUrl('_admin_panel'));
        }

        return [
            'form' => $form->createView(),
            'id' => $id,
        ];
    }

    /**
     * @Route("/training/delete/{id}", name="_admin_training_delete", requirements={"id"="\d+"})
     */
    public function delete(int $id)
    {
        $result = $this->repository()->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($result);
        $em->flush();

        return $this->redirect($this->generateUrl('_admin_panel'));
    }

    private function repository()
    {
        return $this->getDoctrine()->getRepository(Training::class);
    }
}