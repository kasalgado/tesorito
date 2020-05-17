<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Dish;
use App\Form\Type\Admin\DishType;

class DishController extends AbstractController
{
    /**
     * @Route("/dish/create", name="_admin_dish_create")
     * @Route("/dish/edit", name="_admin_dish_edit")
     * @Template()
     */
    public function create(Request $request)
    {
        $id = $request->get('id');
        $dish = $id ? $this->repository()->find($id) : new Dish();
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dish);
            $em->flush();
            
            return $this->redirect($this->generateUrl('_admin_panel'));
        }
        
        return [
            'form' => $form->createView(),
            'id' => $id,
        ];
    }
    
    /**
     * @Route("/dish/delete/{id}", name="_admin_dish_delete", requirements={"id"="\d+"})
     */
    public function delete(int $id)
    {
        $result = $this->getDoctrine()->getRepository(Dish::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($result);
        $em->flush();

        return $this->redirect($this->generateUrl('_admin_panel'));
    }

    private function repository()
    {
        return $this->getDoctrine()->getRepository(Dish::class);
    }
}
