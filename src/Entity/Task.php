<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $on_day;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $completed = false;
    
    public function __construct()
    {
        $this->on_day = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOnDay(): ?\DateTimeInterface
    {
        return $this->on_day;
    }

    public function setOnDay(\DateTimeInterface $on_day): self
    {
        $this->on_day = $on_day;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }
}
