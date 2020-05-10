<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObserverRepository")
 */
class Observer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $last_change;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $widget;

    /**
     * @ORM\Column(type="boolean")
     */
    private $changed;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="observers")
     */
    private $from_user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $to_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastChange(): ?\DateTimeInterface
    {
        return $this->last_change;
    }

    public function setLastChange(\DateTimeInterface $last_change): self
    {
        $this->last_change = $last_change;

        return $this;
    }

    public function getWidget(): ?string
    {
        return $this->widget;
    }

    public function setWidget(string $widget): self
    {
        $this->widget = $widget;

        return $this;
    }

    public function getChanged(): ?bool
    {
        return $this->changed;
    }

    public function setChanged(bool $changed): self
    {
        $this->changed = $changed;

        return $this;
    }

    public function getFromUser(): ?User
    {
        return $this->from_user;
    }

    public function setFromUser(?User $from_user): self
    {
        $this->from_user = $from_user;

        return $this;
    }

    public function getToUser(): ?User
    {
        return $this->to_user;
    }

    public function setToUser(?User $to_user): self
    {
        $this->to_user = $to_user;

        return $this;
    }
}
