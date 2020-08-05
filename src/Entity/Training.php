<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingRepository")
 */
class Training
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
    private $dateAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrainingTask", mappedBy="training", orphanRemoval=true)
     */
    private $trainingtasks;

    public function __construct()
    {
        $this->trainingtasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAt(): ?\DateTimeInterface
    {
        return $this->dateAt;
    }

    public function setDateAt(\DateTimeInterface $dateAt): self
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    /**
     * @return Collection|TrainingTask[]
     */
    public function getTrainingtasks(): Collection
    {
        return $this->trainingtasks;
    }

    public function addTrainingtask(TrainingTask $trainingtask): self
    {
        if (!$this->trainingtasks->contains($trainingtask)) {
            $this->trainingtasks[] = $trainingtask;
            $trainingtask->setTraining($this);
        }

        return $this;
    }

    public function removeTrainingtask(TrainingTask $trainingtask): self
    {
        if ($this->trainingtasks->contains($trainingtask)) {
            $this->trainingtasks->removeElement($trainingtask);
            // set the owning side to null (unless already changed)
            if ($trainingtask->getTraining() === $this) {
                $trainingtask->setTraining(null);
            }
        }

        return $this;
    }
}
