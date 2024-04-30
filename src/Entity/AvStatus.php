<?php

namespace App\Entity;

use App\Repository\AvStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvStatusRepository::class)]
class AvStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, AvBooking>
     */
    #[ORM\OneToMany(targetEntity: AvBooking::class, mappedBy: 'avStatus')]
    private Collection $avBookings;

    public function __construct()
    {
        $this->avBookings = new ArrayCollection();
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
            $avBooking->setAvStatus($this);
        }

        return $this;
    }

    public function removeAvBooking(AvBooking $avBooking): static
    {
        if ($this->avBookings->removeElement($avBooking)) {
            // set the owning side to null (unless already changed)
            if ($avBooking->getAvStatus() === $this) {
                $avBooking->setAvStatus(null);
            }
        }

        return $this;
    }
}
