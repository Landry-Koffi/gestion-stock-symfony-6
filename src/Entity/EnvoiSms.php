<?php

namespace App\Entity;

use App\Repository\EnvoiSmsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnvoiSmsRepository::class)]
class EnvoiSms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $denomination = null;

    #[ORM\Column]
    private ?\DateTime $dateDebutEnvoiAt = null;

    #[ORM\Column]
    private ?\DateTime $dateFinEnvoiAt = null;

    #[ORM\Column(length: 255)]
    private ?string $frequence = null;

    #[ORM\Column(length: 255)]
    private ?string $jourEnvoi = null;

    #[ORM\Column(length: 255)]
    private ?string $heureEnvoi = null;

    #[ORM\Column(length: 255)]
    private ?string $minuteEnvoi = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getDateDebutEnvoiAt(): ?\DateTime
    {
        return $this->dateDebutEnvoiAt;
    }

    public function setDateDebutEnvoiAt(\DateTime $dateDebutEnvoiAt): self
    {
        $this->dateDebutEnvoiAt = $dateDebutEnvoiAt;

        return $this;
    }

    public function getDateFinEnvoiAt(): ?\DateTime
    {
        return $this->dateFinEnvoiAt;
    }

    public function setDateFinEnvoiAt(\DateTime $dateFinEnvoiAt): self
    {
        $this->dateFinEnvoiAt = $dateFinEnvoiAt;

        return $this;
    }

    public function getFrequence(): ?string
    {
        return $this->frequence;
    }

    public function setFrequence(string $frequence): self
    {
        $this->frequence = $frequence;

        return $this;
    }

    public function getJourEnvoi(): ?string
    {
        return $this->jourEnvoi;
    }

    public function setJourEnvoi(string $jourEnvoi): self
    {
        $this->jourEnvoi = $jourEnvoi;

        return $this;
    }

    public function getHeureEnvoi(): ?string
    {
        return $this->heureEnvoi;
    }

    public function setHeureEnvoi(string $heureEnvoi): self
    {
        $this->heureEnvoi = $heureEnvoi;

        return $this;
    }

    public function getMinuteEnvoi(): ?string
    {
        return $this->minuteEnvoi;
    }

    public function setMinuteEnvoi(string $minuteEnvoi): self
    {
        $this->minuteEnvoi = $minuteEnvoi;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
