<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use App\Controller\DataController;
use App\Form\Type\ChatType;
use App\Entity\Chat;
use App\Entity\Money;
use App\Entity\Buy;
use App\Entity\Dish;
use App\Entity\Homework;
use App\Entity\Task;

use App\Service\Daily;

class DefaultController extends DataController
{
    const ENVIRONMENT = 'admin';
    
    /**
     * @Route("/panel", name="_admin_panel")
     * @Template()
     */
    public function panel(
        SessionInterface $session,
        ParameterBagInterface $params,
        Daily $dailyManager
    ): array
    {
        $session->set($params->get('environment_name'), self::ENVIRONMENT);
        $homework = $this->repository(Homework::class)->findOneBy([
            'on_day' => new \Datetime('now'),
        ]);
    	$chat = new Chat();
        $form = $this->createForm(ChatType::class, $chat);
        $dailyManager->calculate(
            $homework ? $homework->getStatus() : self::HOMEWORK_STATUS_YES,
            $this->repository(Task::class)->findByDate()
        );
        
        return $this->responseArrayValues(
            [
                'form' => $form->createView(),
                'dishes' => $this->repository(Dish::class)->findBy([], ['name' => 'ASC']),
                'tasks' => $this->repository(Task::class)->findByDate(),
                'daily' => $dailyManager->get(),
                'products' => $this->repository(Buy::class)->findByEndDay(true),
                'transactions' => $this->repository(Money::class)->findByUserId(),
            ]
        );
    }
}
