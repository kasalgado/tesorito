<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chat", mappedBy="user")
     */
    private $chat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Observer", mappedBy="from_user")
     */
    private $observers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Money", mappedBy="user", orphanRemoval=true)
     */
    private $moneys;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $name;

    public function __construct()
    {
        $this->chat = new ArrayCollection();
        $this->observers = new ArrayCollection();
        $this->moneys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChat(): Collection
    {
        return $this->chat;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chat->contains($chat)) {
            $this->chat[] = $chat;
            $chat->setUser($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chat->contains($chat)) {
            $this->chat->removeElement($chat);
            // set the owning side to null (unless already changed)
            if ($chat->getUser() === $this) {
                $chat->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Observer[]
     */
    public function getObservers(): Collection
    {
        return $this->observers;
    }

    public function addObserver(Observer $observer): self
    {
        if (!$this->observers->contains($observer)) {
            $this->observers[] = $observer;
            $observer->setToUser($this);
        }

        return $this;
    }

    public function removeObserver(Observer $observer): self
    {
        if ($this->observers->contains($observer)) {
            $this->observers->removeElement($observer);
            // set the owning side to null (unless already changed)
            if ($observer->getToUser() === $this) {
                $observer->setToUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Money[]
     */
    public function getMoneys(): Collection
    {
        return $this->moneys;
    }

    public function addMoney(Money $money): self
    {
        if (!$this->moneys->contains($money)) {
            $this->moneys[] = $money;
            $money->setUser($this);
        }

        return $this;
    }

    public function removeMoney(Money $money): self
    {
        if ($this->moneys->contains($money)) {
            $this->moneys->removeElement($money);
            // set the owning side to null (unless already changed)
            if ($money->getUser() === $this) {
                $money->setUser(null);
            }
        }

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
}
