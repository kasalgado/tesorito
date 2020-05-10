<?php declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\MealDish;

class MealDishFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** meal-dish-1 */
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-without-1'));
        $mealDish->setMeals($this->getReference('meal-week-1'));
        $mealDish->setWeekDay(1);
        $manager->persist($mealDish);
        
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-without-2'));
        $mealDish->setMeals($this->getReference('meal-week-1'));
        $mealDish->setWeekDay(2);
        $manager->persist($mealDish);
        
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-with-1'));
        $mealDish->setMeals($this->getReference('meal-week-1'));
        $mealDish->setWeekDay(3);
        $manager->persist($mealDish);
        
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-with-2'));
        $mealDish->setMeals($this->getReference('meal-week-1'));
        $mealDish->setWeekDay(4);
        $manager->persist($mealDish);
        
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-without-1'));
        $mealDish->setMeals($this->getReference('meal-week-1'));
        $mealDish->setWeekDay(5);
        $manager->persist($mealDish);
        
        /** meal-dish-2 */
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-with-1'));
        $mealDish->setMeals($this->getReference('meal-week-2'));
        $mealDish->setWeekDay(1);
        $manager->persist($mealDish);
        
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-with-2'));
        $mealDish->setMeals($this->getReference('meal-week-2'));
        $mealDish->setWeekDay(2);
        $manager->persist($mealDish);
        
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-without-1'));
        $mealDish->setMeals($this->getReference('meal-week-2'));
        $mealDish->setWeekDay(3);
        $manager->persist($mealDish);
        
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-without-2'));
        $mealDish->setMeals($this->getReference('meal-week-2'));
        $mealDish->setWeekDay(4);
        $manager->persist($mealDish);
        
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-without-1'));
        $mealDish->setMeals($this->getReference('meal-week-2'));
        $mealDish->setWeekDay(5);
        $manager->persist($mealDish);
        
        /** meal-dish-3 */
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-with-1'));
        $mealDish->setMeals($this->getReference('meal-week-3'));
        $mealDish->setWeekDay(1);
        $manager->persist($mealDish);
        
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-without-2'));
        $mealDish->setMeals($this->getReference('meal-week-3'));
        $mealDish->setWeekDay(2);
        $manager->persist($mealDish);
        
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-with-2'));
        $mealDish->setMeals($this->getReference('meal-week-3'));
        $mealDish->setWeekDay(3);
        $manager->persist($mealDish);
        
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-without-1'));
        $mealDish->setMeals($this->getReference('meal-week-3'));
        $mealDish->setWeekDay(4);
        $manager->persist($mealDish);
        
        $mealDish = new MealDish();
        $mealDish->setDishes($this->getReference('dish-with-1'));
        $mealDish->setMeals($this->getReference('meal-week-3'));
        $mealDish->setWeekDay(5);
        $manager->persist($mealDish);
        
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return [
            DishFixtures::class,
            MealFixtures::class,
        ];
    }
}
