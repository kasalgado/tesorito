<?php declare (strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Meal;
use App\Entity\MealDish;
use App\Entity\Dish;
use App\Form\Type\MealType;
use App\Repository\MealRepository;
use App\Utils\WeekDays;

class DiningPlanController extends AbstractController
{
    /**
     * @Route("/dinnig-plan/create", name="_dining_plan_create")
     * @Template()
     */
    public function create(Request $request)
    {
        $meal = $this->repository()->findOneBy(['week' => $request->get('week')]) ?: new Meal();
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->setMealDish($meal, $request->get('dish'));
            
            return $this->redirect($this->generateUrl('_admin_panel'));
        }
        
        return [
            'form' => $form->createView(),
            'week' => $form->get('week')->getData(),
        ];
    }
    
    /**
     * @Route("/dining-plan/fetch", name="_dining_plan_fetch", methods={"POST"})
     * @Template()
     */
    public function fetch(Request $request, WeekDays $days)
    {
        $meal = $this->repository()->findOneBy([
            'week' => $request->get('week'),
        ]);
        
        return [
            'week' => $request->get('week'),
            'meal' => $meal,
            'mealDishes' => $this->getDoctrine()->getRepository(MealDish::class)->findBy(['meals' => $meal]),
            'dishes' => $this->getDoctrine()->getRepository(Dish::class)->findBy([], ['name' => 'ASC']),
            'days' => $days->get(),
        ];
    }
    
    private function setMealDish(Meal $meal, array $dishes): void
    {
        $em = $this->getDoctrine()->getManager();

        for ($d = 0; $d <= 4; $d++) {
            if ($dishes[$d]) {
                $dish = $this->getDoctrine()->getRepository(Dish::class)
                    ->find($dishes[$d]);
                $mealDish = $this->getDoctrine()->getRepository(MealDish::class)
                    ->findOneBy(['week_day' => $d + 1, 'meals' => $meal])
                    ?: new MealDish();
                $mealDish->setDishes($dish);
                $mealDish->setWeekDay($d + 1);
                $mealDish->setMeals($meal);
                $meal->addMealDish($mealDish);
            } else {
                $mealDish = $this->getDoctrine()->getRepository(MealDish::class)
                    ->findOneBy(['week_day' => $d + 1, 'meals' => $meal]);

                if ($mealDish) {
                    $em->remove($mealDish);
                    $em->flush();
                }
            }
        }

        $em->persist($meal);
        $em->flush();
    }
    
    private function repository(): MealRepository
    {
        return $this->getDoctrine()->getRepository(Meal::class);
    }
}
