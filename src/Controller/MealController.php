<?php declare (strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Meal;
use App\Utils\WeekDays;
use App\Repository\MealRepository;

class MealController extends AbstractController
{
    /**
     * @Route("/meal/show/{week}", name="_meal_show", requirements={"week"="\d+"}, methods={"POST"})
     * @Template("/meal/default.html.twig")
     */
    public function show(int $week, WeekDays $days): array
    {
        return [
            'meals' => $this->repository()->findByWeek($week),
            'nextWeek' => $this->repository()->findNextWeek($week),
            'backWeek' => $this->repository()->findBackWeek($week),
            'week' => $week,
            'days' => $days->get(),
        ];
    }
    
    /**
     * @Route("/meal/update/week/{id}", name="_meal_update_week", requirements={"id"="\d+"})
     */
    public function updateWeek(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $meal = $this->repository()->find($id);
        $meal->setWeek((int) $request->get('week'));
        $em->persist($meal);
        $em->flush();

        return new Response(json_encode(['id' => $id]));
    }
    
    private function repository(): MealRepository
    {
        return $this->getDoctrine()->getRepository(Meal::class);
    }
}
