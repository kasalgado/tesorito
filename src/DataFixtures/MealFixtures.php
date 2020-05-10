<?php declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Meal;

class MealFixtures extends Fixture
{
    public const MEAL_WEEK_1 = 'meal-week-1';
    public const MEAL_WEEK_2 = 'meal-week-2';
    public const MEAL_WEEK_3 = 'meal-week-3';
    
    public function load(ObjectManager $manager): void
    {
        $meal1 = new Meal();
        $meal1->setWeek((int) date('W'));
        $manager->persist($meal1);
        
        $meal2 = new Meal();
        $meal2->setWeek((int) date('W') - 1);
        $manager->persist($meal2);
        
        $meal3 = new Meal();
        $meal3->setWeek((int) date('W') + 1);
        $manager->persist($meal3);
        
        $manager->flush();
        
        $this->addReference(self::MEAL_WEEK_1, $meal1);
        $this->addReference(self::MEAL_WEEK_2, $meal2);
        $this->addReference(self::MEAL_WEEK_3, $meal3);
    }
}
