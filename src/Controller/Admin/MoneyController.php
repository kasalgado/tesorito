<?php declare (strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Money as MoneyEntity;
use App\Form\Admin\AccountType;
use App\Service\Money;
use App\Service\TransactionInterface;
use App\Service\Deposit;
use App\Service\Withdraw;

class MoneyController extends AbstractController
{
    /**
     * @Route("/money/create", name="_admin_money_create")
     * @Template()
     */
    public function create(Request $request, Money $money)
    {
        $entity = new MoneyEntity();
        $form = $this->createForm(AccountType::class, $entity);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $amount = $form->get('amount')->getData();
            $entity->setBalance($this->getLastTransaction());
            $money->transaction($entity, $this->transactionType($form));
            $money->getTransaction()->make($money, $amount);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($money->getEntity());
            $em->flush();
            
            return $this->redirect($this->generateUrl('_admin_panel'));
        }
        
        return [
            'form' => $form->createView(),
          ];
    }
    
    private function getLastTransaction(): float
    {
        $last = $this->getDoctrine()->getRepository(MoneyEntity::class)->findBy([], ['id' => 'DESC'], 1);
        
        return $last ? $last[0]->getBalance() : 0.0;
    }
    
    private function transactionType($form): TransactionInterface
    {
        return $form->get('trans_type')->getData() === Money::TRANSACTION_DEPOSIT ? new Deposit() : new Withdraw();
    }
}
