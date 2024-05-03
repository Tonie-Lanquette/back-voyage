<?php

namespace App\Entity;

use App\Repository\AvFormsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvFormsRepository::class)]
class AvForms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $message = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?avBooking $avBooking = null;

    #[ORM\ManyToOne(inversedBy: 'avForms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AvUser $avUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getAvBooking(): ?avBooking
    {
        return $this->avBooking;
    }

    public function setAvBooking(avBooking $avBooking): static
    {
        $this->avBooking = $avBooking;

        return $this;
    }

    public function getAvUser(): ?AvUser
    {
        return $this->avUser;
    }

    public function setAvUser(?AvUser $avUser): static
    {
        $this->avUser = $avUser;

        return $this;
    }
}
