<?php

namespace App\Entity;

use App\Repository\AvTravelsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NoSuspiciousCharacters;

#[ORM\Entity(repositoryClass: AvTravelsRepository::class)]
class AvTravels
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api_av_travels_index'])]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: "L'image ne peut pas être vide.")]
    #[Assert\Length(min: 5, max: 500, minMessage: "Le lien doit comporter plus de {{ limit }} caractères.", maxMessage: "Le lien doit comporter maximum {{ limit }} caractères.")]
    #[Assert\NoSuspiciousCharacters(checks: NoSuspiciousCharacters::CHECK_INVISIBLE, restrictionLevel: NoSuspiciousCharacters::RESTRICTION_LEVEL_HIGH)]
    #[Groups(['api_av_travels_index'])]
    private ?string $picture = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom du voyage ne peut pas être vide.")]
    #[Assert\Length(min: 5, max: 70, minMessage: "Le nom du voyage doit comporter plus de {{ limit }} caractères.", maxMessage: "Le nom du voyage doit comporter maximum {{ limit }} caractères.")]
    #[Assert\NoSuspiciousCharacters(checks: NoSuspiciousCharacters::CHECK_INVISIBLE, restrictionLevel: NoSuspiciousCharacters::RESTRICTION_LEVEL_HIGH)]
    #[Groups(['api_av_travels_index'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['api_av_travels_show'])]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La durée du voyage ne peut pas être vide.")]
    #[Assert\Length(min: 1, max: 100, minMessage: "La durée du voyage doit comporter plus de {{ limit }} caractères.", maxMessage: "La durée du voyage doit comporter maximum {{ limit }} caractères.")]
    #[Assert\NoSuspiciousCharacters(checks: NoSuspiciousCharacters::CHECK_INVISIBLE, restrictionLevel: NoSuspiciousCharacters::RESTRICTION_LEVEL_HIGH)]
    #[Groups(['api_av_travels_index'])]
    private ?int $duration = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le prix du voyage ne peut pas être vide.")]
    #[Assert\Length(min: 2, max: 10, minMessage: "Le prix du voyage doit comporter plus de {{ limit }} caractères.", maxMessage: "Le prix du voyage doit comporter maximum {{ limit }} caractères.")]
    #[Assert\NoSuspiciousCharacters(checks: NoSuspiciousCharacters::CHECK_INVISIBLE, restrictionLevel: NoSuspiciousCharacters::RESTRICTION_LEVEL_HIGH)]
    #[Groups(['api_av_travels_index'])]
    private ?int $price = null;

    /**
     * @var Collection<int, avCountries>
     */
    #[ORM\ManyToMany(targetEntity: AvCountries::class, inversedBy: 'avTravels')]
    #[Groups(['api_av_travels_index'])]
    private Collection $avCountries;

   

    /**
     * @var Collection<int, AvBooking>
     */
    #[ORM\OneToMany(targetEntity: AvBooking::class, mappedBy: 'avTravels')]
    // #[Groups(['api_av_travels_index'])]
    private Collection $avBookings;

    #[ORM\ManyToOne(inversedBy: 'avTravels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?avUser $avUser = null;

    /**
     * @var Collection<int, AvCategories>
     */
    #[ORM\ManyToMany(targetEntity: AvCategories::class, inversedBy: 'avTravels')]
    #[Groups(['api_av_travels_index'])]
    private Collection $AvCategories;

    public function __construct()
    {
        $this->avCountries = new ArrayCollection();
        $this->AvCategories = new ArrayCollection();
        $this->avBookings = new ArrayCollection();
        $this->AvCategories = new ArrayCollection();
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

    /**
     * @return Collection<int, AvCategories>
     */
    public function getAvCategories(): Collection
    {
        return $this->AvCategories;
    }

    public function addAvCategory(AvCategories $avCategory): static
    {
        if (!$this->AvCategories->contains($avCategory)) {
            $this->AvCategories->add($avCategory);
        }

        return $this;
    }

    public function removeAvCategory(AvCategories $avCategory): static
    {
        $this->AvCategories->removeElement($avCategory);

        return $this;
    }
}
