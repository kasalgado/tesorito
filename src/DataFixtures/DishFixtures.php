<?php declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Dish;

class DishFixtures extends Fixture
{
    public const DISH_WITHOUT_1 = 'dish-without-1';
    public const DISH_WITHOUT_2 = 'dish-without-2';
    public const DISH_WITH_1 = 'dish-with-1';
    public const DISH_WITH_2 = 'dish-with-2';
    
    public function load(ObjectManager $manager): void
    {
        $dish1 = new Dish();
        $dish1->setDishType(1);
        $dish1->setName('Without 1');
        $manager->persist($dish1);
        
        $dish2 = new Dish();
        $dish2->setDishType(1);
        $dish2->setName('Without 2');
        $manager->persist($dish2);
        
        $dish3 = new Dish();
        $dish3->setDishType(2);
        $dish3->setName('With 1');
        $manager->persist($dish3);
        
        $dish4 = new Dish();
        $dish4->setDishType(2);
        $dish4->setName('With 2');
        $manager->persist($dish4);
        
        $manager->flush();
        
        $this->addReference(self::DISH_WITHOUT_1, $dish1);
        $this->addReference(self::DISH_WITHOUT_2, $dish2);
        $this->addReference(self::DISH_WITH_1, $dish3);
        $this->addReference(self::DISH_WITH_2, $dish4);
    }
}
