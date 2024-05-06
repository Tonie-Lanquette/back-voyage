<?php

namespace App\Entity;

use App\Repository\AvTravelsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvTravelsRepository::class)]
class AvTravels
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $picture = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column]
    private ?int $price = null;

    /**
     * @var Collection<int, avCountries>
     */
    #[ORM\ManyToMany(targetEntity: AvCountries::class, inversedBy: 'avTravels')]
    private Collection $avCountries;

    /**
     * @var Collection<int, AvCategories>
     */
    #[ORM\ManyToMany(targetEntity: AvCategories::class, mappedBy: 'avTravels')]
    private Collection $avCategories;

    /**
     * @var Collection<int, AvBooking>
     */
    #[ORM\OneToMany(targetEntity: AvBooking::class, mappedBy: 'avTravels')]
    private Collection $avBookings;

    #[ORM\ManyToOne(inversedBy: 'avTravels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?avUser $avUser = null;

    public function __construct()
    {
        $this->avCountries = new ArrayCollection();
        $this->avCategories = new ArrayCollection();
        $this->avBookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): static
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, avCountries>
     */
    public function getAvCountries(): Collection
    {
        return $this->avCountries;
    }

    public function addAvCountry(avCountries $avCountry): static
    {
        if (!$this->avCountries->contains($avCountry)) {
            $this->avCountries->add($avCountry);
        }

        return $this;
    }

    public function removeAvCountry(avCountries $avCountry): static
    {
        $this->avCountries->removeElement($avCountry);

        return $this;
    }

    /**
     * @return Collection<int, AvCategories>
     */
    public function getAvCategories(): Collection
    {
        return $this->avCategories;
    }

    public function addAvCategory(AvCategories $avCategory): static
    {
        if (!$this->avCategories->contains($avCategory)) {
            $this->avCategories->add($avCategory);
            $avCategory->addAvTravel($this);
        }

        return $this;
    }

    public function removeAvCategory(AvCategories $avCategory): static
    {
        if ($this->avCategories->removeElement($avCategory)) {
            $avCategory->removeAvTravel($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, AvBooking>
     */
    public function getAvBookings(): Collection
    {
        return $this->avBookings;
    }

    public function addAvBooking(AvBooking $avBooking): static
    {
        if (!$this->avBookings->contains($avBooking)) {
            $this->avBookings->add($avBooking);
            $avBooking->setAvTravels($this);
        }

        return $this;
    }

    public function removeAvBooking(AvBooking $avBooking): static
    {
        if ($this->avBookings->removeElement($avBooking)) {
            // set the owning side to null (unless already changed)
            if ($avBooking->getAvTravels() === $this) {
                $avBooking->setAvTravels(null);
            }
        }

        return $this;
    }

    public function getAvUser(): ?avUser
    {
        return $this->avUser;
    }

    public function setAvUser(?avUser $avUser): static
    {
        $this->avUser = $avUser;

        return $this;
    }
}
