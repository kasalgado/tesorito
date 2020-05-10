<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Chat;
use App\Entity\Homework;
use App\Entity\Meal;
use App\Entity\Appointment;

use App\Utils\WeekDays;

abstract class DataController extends AbstractController
{
    const HOMEWORK_STATUS_YES = 'yes';
    
    private $days;
    private $translator;
    
    public function __construct(WeekDays $days, TranslatorInterface $translator)
    {
        $this->days = $days;
        $this->translator = $translator;
    }
    
    protected function responseArrayValues(array $requestElements): array
    {
        $request = array_merge($this->templateVariables(), $requestElements);
        $request['js'] = [
            'url_monitor_observer' => $this->generateUrl('_monitor_widget_observer'),
            'text_daily_title' => $this->translator->trans('daily.total'),
            'text_daily_points' => $this->translator->trans('daily.points'),
        ];
        
        return $request;
    }
    
    private function templateVariables(): array
    {
        return [
            'days' => $this->days->get(),
            'messages' => $this->getDoctrine()->getRepository(Chat::class)->findByDateTime(),
            'homework' => $this->getDoctrine()->getRepository(Homework::class)->findOneBy([
                'on_day' => new \Datetime('now'),
            ]),
            'appointments' => $this->repository(Appointment::class)->findByDate(),
            'week' => date('W'),
            'meals' => $this->repository(Meal::class)->findByWeek(date('W')),
            'nextWeek' => $this->repository(Meal::class)->findNextWeek(date('W')),
            'backWeek' => $this->repository(Meal::class)->findBackWeek(date('W')),
        ];
    }
    
    protected function repository($entity)
    {
        return $this->getDoctrine()->getRepository($entity);
    }
}
