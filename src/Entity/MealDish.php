<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MealDishRepository")
 */
class MealDish
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $week_day;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Meal", inversedBy="mealDishes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $meals;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dish", inversedBy="mealDishes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dishes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeekDay(): ?int
    {
        return $this->week_day;
    }

    public function setWeekDay(int $week_day): self
    {
        $this->week_day = $week_day;

        return $this;
    }

    public function getMeals(): ?Meal
    {
        return $this->meals;
    }

    public function setMeals(?Meal $meals): self
    {
        $this->meals = $meals;

        return $this;
    }

    public function getDishes(): ?Dish
    {
        return $this->dishes;
    }

    public function setDishes(?Dish $dishes): self
    {
        $this->dishes = $dishes;

        return $this;
    }
}
