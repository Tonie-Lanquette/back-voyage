<?php

namespace App\Entity;

use App\Repository\AvBookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvBookingRepository::class)]
class AvBooking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'avBookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?avStatus $avStatus = null;

    #[ORM\ManyToOne(inversedBy: 'avBookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?avTravels $avTravels = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?avForms $avForms = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvStatus(): ?avStatus
    {
        return $this->avStatus;
    }

    public function setAvStatus(?avStatus $avStatus): static
    {
        $this->avStatus = $avStatus;

        return $this;
    }

    public function getAvTravels(): ?avTravels
    {
        return $this->avTravels;
    }

    public function setAvTravels(?avTravels $avTravels): static
    {
        $this->avTravels = $avTravels;

        return $this;
    }

    public function getAvForms(): ?avForms
    {
        return $this->avForms;
    }

    public function setAvForms(avForms $avForms): static
    {
        $this->avForms = $avForms;

        return $this;
    }
}
