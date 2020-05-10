<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChatRepository")
 */
class Chat
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
    private $date_time;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $chat_text;

    /**
     * @ORM\Column(type="boolean")
     */
    private $new_message;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userChecking;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="chat")
     */
    private $user;

    public function __construct()
    {
        $this->date_time = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->date_time;
    }

    public function setDateTime(\DateTimeInterface $date_time): self
    {
        $this->date_time = $date_time;

        return $this;
    }

    public function getChatText(): ?string
    {
        return $this->chat_text;
    }

    public function setChatText(string $chat_text): self
    {
        $this->chat_text = $chat_text;

        return $this;
    }

    public function getNewMessage(): ?bool
    {
        return $this->new_message;
    }

    public function setNewMessage(bool $new_message): self
    {
        $this->new_message = $new_message;

        return $this;
    }

    public function getUserChecking(): ?string
    {
        return $this->userChecking;
    }

    public function setUserChecking(string $userChecking): self
    {
        $this->userChecking = $userChecking;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
