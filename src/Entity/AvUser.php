<?php

namespace App\Entity;

use App\Repository\AvUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NoSuspiciousCharacters;

#[ORM\Entity(repositoryClass: AvUserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé')]
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
    #[Assert\NotBlank(message: "Le mot de passe ne peut pas être vide.")]
    #[Assert\Length(min: 5, max: 70, minMessage: "Le mot de passe doit comporter plus de {{ limit }} caractères.", maxMessage: "Le mot de passe doit comporter maximum {{ limit }} caractères.")]
    #[Assert\NoSuspiciousCharacters(checks: NoSuspiciousCharacters::CHECK_INVISIBLE, restrictionLevel: NoSuspiciousCharacters::RESTRICTION_LEVEL_HIGH)]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le prénom ne peut pas être vide.")]
    #[Assert\Length(min: 3, max: 50, minMessage: "Le prénom doit comporter plus de {{ limit }} caractères.", maxMessage: "Le prénom doit comporter maximum {{ limit }} caractères.")]
    #[Assert\NoSuspiciousCharacters(checks: NoSuspiciousCharacters::CHECK_INVISIBLE, restrictionLevel: NoSuspiciousCharacters::RESTRICTION_LEVEL_HIGH)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide.")]
    #[Assert\Length(min: 5, max: 50, minMessage: "Le nom doit comporter plus de {{ limit }} caractères.", maxMessage: "Le nom doit comporter maximum {{ limit }} caractères.")]
    #[Assert\NoSuspiciousCharacters(checks: NoSuspiciousCharacters::CHECK_INVISIBLE, restrictionLevel: NoSuspiciousCharacters::RESTRICTION_LEVEL_HIGH)]
    private ?string $lastName = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(message: "Le numéro de téléphone ne peut pas être vide.")]
    #[Assert\Length(min: 10, max: 15, minMessage: "Le numéro de téléphone doit comporter plus de {{ limit }} caractères.", maxMessage: "Le numéro de téléphone doit comporter maximum {{ limit }} caractères.")]
    #[Assert\NoSuspiciousCharacters(checks: NoSuspiciousCharacters::CHECK_INVISIBLE, restrictionLevel: NoSuspiciousCharacters::RESTRICTION_LEVEL_HIGH)]
    private ?string $phone = null;

    /**
     * @var Collection<int, AvTravels>
     */
    #[ORM\OneToMany(targetEntity: AvTravels::class, mappedBy: 'avUser')]
    private Collection $avTravels;

    /**
     * @var Collection<int, avForms>
     */
    #[ORM\OneToMany(targetEntity: AvForms::class, mappedBy: 'avUser')]
    private Collection $avForms;

    #[ORM\Column]
    private bool $isVerified = false;

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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
