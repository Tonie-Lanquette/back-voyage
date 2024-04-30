<?php

namespace App\Entity;

use App\Repository\AvCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvCategoriesRepository::class)]
class AvCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
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
