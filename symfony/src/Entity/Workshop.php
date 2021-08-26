<?php

namespace App\Entity;

use App\Repository\WorkshopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkshopRepository::class)
 */
class Workshop
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startsAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endsAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $capacity;

    /**
     * @ORM\ManyToOne(targetEntity=Program::class, inversedBy="workshops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $program;

    /**
     * @ORM\Column(type="integer")
     */
    private $statusCode;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    private $currentRegistered;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="workshops")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getStartsAt(): ?\DateTimeInterface
    {
        return $this->startsAt;
    }

    public function setStartsAt(?\DateTimeInterface $startsAt): self
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    public function getEndsAt(): ?\DateTimeInterface
    {
        return $this->endsAt;
    }

    public function setEndsAt(?\DateTimeInterface $endsAt): self
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): self
    {
        $this->program = $program;

        return $this;
    }

    public function getProgramImageFilename()
    {
        return 'images/programs/'.$this->program->getImageFilename();
    }

    public function getStatusCode(): ?int
    {
        $this->workshopStatusCode();

        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode = null): self
    {
        $this->workshopStatusCode();

        return $this;
    }

    public function workshopStatusCode()
    {
        $now = new \DateTime();

        if ($now >= $this->getStartsAt() && $now <= $this->getEndsAt()) {
            $this->statusCode = 0; // Ongoing event
        } else if ($now > $this->getEndsAt()) {
            $this->statusCode = -1; // Past event
        } else if ($now < $this->getStartsAt()) {
            $this->statusCode = 1; // Future event
        }
    }

    public function getCurrentRegistered(): ?int
    {
        return $this->currentRegistered;
    }

    public function setCurrentRegistered(int $currentRegistered): self
    {
        $this->currentRegistered = $currentRegistered;

        return $this;
    }

    public function getRemainingCapacity(): ?int
    {
        return $this->capacity - $this->currentRegistered;
    }

    public function getCapacityPercentage()
    {
        return round($this->currentRegistered / $this->capacity * 100);
    }

    public function addCurrentRegistered()
    {
        $this->currentRegistered++;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addWorkshop($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeWorkshop($this);
        }

        return $this;
    }
}
