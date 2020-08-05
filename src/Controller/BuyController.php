<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Buy;
use App\Form\BuyType;
use App\Service\Observer;
use App\Service\DataCache;
use App\Repository\BuyRepository;

class BuyController extends AbstractController
{
    /**
     * @Route("/buy/create", name="_buy_create")
     * @Route("/buy/edit", name="_buy_edit")
     * @Template()
     */
    public function create(Request $request, Observer $observer, EntityManagerInterface $em)
    {
        $id = $request->get('id');
        $buy = $id ? $this->repository()->find($id) : new Buy();
        $form = $this->createForm(BuyType::class, $buy);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($buy);
            $em->flush();

            $observer->update('buy');

            return $this->redirect($this->generateUrl('_admin_panel'));
        }
        
        return [
            'form' => $form->createView(),
            'id' => $id,
        ];
    }
    
    /**
     * @Route("/buy/delete/{id}", name="_buy_delete", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function delete(int $id, Observer $observer, EntityManagerInterface $em)
    {
        $result = $this->repository()->find($id);
        $em->remove($result);
        $em->flush();

        $observer->update('buy');

        return $this->redirect($this->generateUrl('_admin_panel'));
    }
    
    /**
     * @Route("/buy/list", name="_buy_list", methods={"POST"})
     * @Template("/buy/default.html.twig")
     */
    public function list(DataCache $cache): array
    {
        $buys = $this->repository()->findByEndDay();
        
        return [
            'products' => $cache->get($buys, 'buy'),
        ];
    }
    
    /**
     * @Route("/buy/completed/{id}", name="_buy_completed", requirements={"id"="\d+"})
     * @Template("/buy/default.html.twig")
     */
    public function completed(int $id, Observer $observer, EntityManagerInterface $em)
    {
        $buy = $this->repository()->find($id)->setCompleted(true);
        $em->persist($buy);
        $em->flush();

        $observer->update('buy');

        return ['products' => $this->repository()->findByEndDay()];
    }
    
    private function repository(): BuyRepository
    {
        return $this->getDoctrine()->getRepository(Buy::class);
    }
}
