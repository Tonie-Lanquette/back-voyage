<?php

namespace App\Entity;

use App\Repository\AvUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AvUserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class AvUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    private ?string $lastName = null;

    #[ORM\Column(length: 15)]
    private ?string $phone = null;

    /**
     * @var Collection<int, AvTravels>
     */
    #[ORM\OneToMany(targetEntity: AvTravels::class, mappedBy: 'avUser')]
    private Collection $avTravels;

    /**
     * @var Collection<int, avForms>
     */
    #[ORM\OneToMany(targetEntity: avForms::class, mappedBy: 'avUser')]
    private Collection $avForms;

    public function __construct()
    {
        $this->avTravels = new ArrayCollection();
        $this->avForms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, AvTravels>
     */
    public function getAvTravels(): Collection
    {
        return $this->avTravels;
    }

    public function addAvTravel(AvTravels $avTravel): static
    {
        if (!$this->avTravels->contains($avTravel)) {
            $this->avTravels->add($avTravel);
            $avTravel->setAvUser($this);
        }

        return $this;
    }

    public function removeAvTravel(AvTravels $avTravel): static
    {
        if ($this->avTravels->removeElement($avTravel)) {
            // set the owning side to null (unless already changed)
            if ($avTravel->getAvUser() === $this) {
                $avTravel->setAvUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, avForms>
     */
    public function getAvForms(): Collection
    {
        return $this->avForms;
    }

    public function addAvForm(avForms $avForm): static
    {
        if (!$this->avForms->contains($avForm)) {
            $this->avForms->add($avForm);
            $avForm->setAvUser($this);
        }

        return $this;
    }

    public function removeAvForm(avForms $avForm): static
    {
        if ($this->avForms->removeElement($avForm)) {
            // set the owning side to null (unless already changed)
            if ($avForm->getAvUser() === $this) {
                $avForm->setAvUser(null);
            }
        }

        return $this;
    }
}
