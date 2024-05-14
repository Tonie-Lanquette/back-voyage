<?php

namespace App\Entity;

use App\Repository\AvCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NoSuspiciousCharacters;

#[ORM\Entity(repositoryClass: AvCategoriesRepository::class)]
class AvCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le nom de la catégorie ne peut pas être vide.")]
    #[Assert\Length(min: 5, max: 50, minMessage: "Le nom de la catégorie doit comporter plus de {{ limit }} caractères.", maxMessage: "Le nom de la catégorie doit comporter maximum {{ limit }} caractères.")]
    #[Assert\NoSuspiciousCharacters(checks: NoSuspiciousCharacters::CHECK_INVISIBLE, restrictionLevel: NoSuspiciousCharacters::RESTRICTION_LEVEL_HIGH)]
    private ?string $name = null;

    /**
     * @var Collection<int, avTravels>
     */
    #[ORM\ManyToMany(targetEntity: avTravels::class, inversedBy: 'avCategories')]
    private Collection $avTravels;

    public function __construct()
    {
        $this->avTravels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, avTravels>
     */
    public function getAvTravels(): Collection
    {
        return $this->avTravels;
    }

    public function addAvTravel(avTravels $avTravel): static
    {
        if (!$this->avTravels->contains($avTravel)) {
            $this->avTravels->add($avTravel);
        }

        return $this;
    }

    public function removeAvTravel(avTravels $avTravel): static
    {
        $this->avTravels->removeElement($avTravel);

        return $this;
    }
}
