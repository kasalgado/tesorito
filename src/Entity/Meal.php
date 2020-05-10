<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MealRepository")
 */
class Meal
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
    private $week;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MealDish", mappedBy="meals", orphanRemoval=true, cascade={"persist"})
     */
    private $mealDishes;

    public function __construct()
    {
        $this->mealDishes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeek(): ?int
    {
        return $this->week;
    }

    public function setWeek(int $week): self
    {
        $this->week = $week;

        return $this;
    }

    /**
     * @return Collection|MealDish[]
     */
    public function getMealDishes(): Collection
    {
        return $this->mealDishes;
    }

    public function addMealDish(MealDish $mealDish): self
    {
        if (!$this->mealDishes->contains($mealDish)) {
            $this->mealDishes[] = $mealDish;
            $mealDish->setMeals($this);
        }

        return $this;
    }

    public function removeMealDish(MealDish $mealDish): self
    {
        if ($this->mealDishes->contains($mealDish)) {
            $this->mealDishes->removeElement($mealDish);
            // set the owning side to null (unless already changed)
            if ($mealDish->getMeals() === $this) {
                $mealDish->setMeals(null);
            }
        }

        return $this;
    }
}
