<?php

namespace App\Controller\Monitor;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use App\Controller\DataController;
use App\Entity\Buy;
use App\Entity\Homework;
use App\Entity\Task;

use App\Service\Daily;

class DefaultController extends DataController
{
    const ENVIRONMENT = 'monitor';
    
    /**
     * @Route("/", name="_monitor")
     * @Template()
     */
    public function indexAction(
        SessionInterface $session,
        ParameterBagInterface $params,
        Daily $dailyManager
    ): array
    {
        $session->set($params->get('environment_name'), self::ENVIRONMENT);
        $homework = $this->repository(Homework::class)->findOneBy([
            'on_day' => new \Datetime('now'),
        ]);
        $tasks = $this->repository(Task::class)->findByDate();
        $dailyManager->calculate(
            $homework ? $homework->getStatus() : self::HOMEWORK_STATUS_YES,
            $tasks
        );
        
        return $this->responseArrayValues(
            [
                'tasks' => $tasks,
                'daily' => $dailyManager->get(),
                'products' => $this->repository(Buy::class)->findByEndDay(),
            ]
        );
    }
}
