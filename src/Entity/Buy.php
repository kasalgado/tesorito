<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BuyRepository")
 */
class Buy
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
    private $end_day;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $completed;
    
    public function __construct()
    {
        $this->end_day = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEndDay(): ?\DateTimeInterface
    {
        return $this->end_day;
    }

    public function setEndDay(\DateTimeInterface $end_day): self
    {
        $this->end_day = $end_day;

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
