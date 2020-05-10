<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Observer;
use App\Entity\Homework;
use App\Entity\Task;

use App\Service\Daily;

class WidgetController extends AbstractController
{
    const HOMEWORK_STATUS_YES = 'yes';

    /**
     * @Route("/daily/update", name="_daily_update", methods={"POST"})
     * @Template("/daily/default.html.twig")
     */
    public function dailyUpdate(Daily $dailyManager)
    {
        $homework = $this->getDoctrine()->getRepository(Homework::class)->findOneBy([
            'on_day' => new \Datetime('now'),
        ]);
        $dailyManager->calculate(
            $homework ? $homework->getStatus() : self::HOMEWORK_STATUS_YES,
            $this->getDoctrine()->getRepository(Task::class)->findByDate()
        );
        
        return ['daily' => $dailyManager->get()];
    }
    
    /**
     * @Route("/widget/observer", name="_monitor_widget_observer", methods={"POST"})
     */
    public function observer()
    {
        $repo = $this->getDoctrine()->getRepository(Observer::class);
        $result = $repo->findBy(['to_user' => $this->getUser(), 'changed' => true]);
        
        $em = $this->getDoctrine()->getManager();
        $results = [];

        /** @var Observer $value */
        foreach ($result as $key => $value) {
            $results[$key] = $value->getWidget();

            $widget = $repo->findOneBy(['to_user' => $this->getUser(), 'widget' => $value->getWidget()]);
            $widget->setChanged(false);

            $em->persist($widget);
            $em->flush();
        }
        
        return new Response(json_encode($results));
    }
}
