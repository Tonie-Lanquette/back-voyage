<?php

namespace App\Entity;

use App\Repository\AvCountriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NoSuspiciousCharacters;

#[ORM\Entity(repositoryClass: AvCountriesRepository::class)]
class AvCountries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le nom du pays ne peut pas être vide.")]
    #[Assert\Length(min: 5, max: 70, minMessage: "Le nom du pays doit comporter plus de {{ limit }} caractères.", maxMessage: "Le nom du pays doit comporter maximum {{ limit }} caractères.")]
    #[Assert\NoSuspiciousCharacters(checks: NoSuspiciousCharacters::CHECK_INVISIBLE, restrictionLevel: NoSuspiciousCharacters::RESTRICTION_LEVEL_HIGH)]
    #[Groups(['api_av_travels_index', 'api_av_countries_index'])]
    private ?string $name = null;

    /**
     * @var Collection<int, AvTravels>
     */
    #[ORM\ManyToMany(targetEntity: AvTravels::class, mappedBy: 'avCountries')]
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
            $avTravel->addAvCountry($this);
        }

        return $this;
    }

    public function removeAvTravel(AvTravels $avTravel): static
    {
        if ($this->avTravels->removeElement($avTravel)) {
            $avTravel->removeAvCountry($this);
        }

        return $this;
    }
}
