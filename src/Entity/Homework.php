<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HomeworkRepository")
 */
class Homework
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
     * @ORM\Column(type="string", length=16)
     */
    private $status;
    
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
