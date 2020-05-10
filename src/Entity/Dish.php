<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DishRepository")
 */
class Dish
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
    private $dish_type;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MealDish", mappedBy="dishes", orphanRemoval=true)
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

    public function getDishType(): ?int
    {
        return $this->dish_type;
    }

    public function setDishType(int $dish_type): self
    {
        $this->dish_type = $dish_type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $mealDish->setDishes($this);
        }

        return $this;
    }

    public function removeMealDish(MealDish $mealDish): self
    {
        if ($this->mealDishes->contains($mealDish)) {
            $this->mealDishes->removeElement($mealDish);
            // set the owning side to null (unless already changed)
            if ($mealDish->getDishes() === $this) {
                $mealDish->setDishes(null);
            }
        }

        return $this;
    }
}
