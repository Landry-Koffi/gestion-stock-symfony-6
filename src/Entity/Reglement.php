<?php

namespace App\Entity;

use App\Repository\ReglementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReglementRepository::class)]
class Reglement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CommandeClient $commandeClient = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MoyenReglement $modeReglement = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $echeanceAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommandeClient(): ?CommandeClient
    {
        return $this->commandeClient;
    }

    public function setCommandeClient(?CommandeClient $commandeClient): self
    {
        $this->commandeClient = $commandeClient;

        return $this;
    }

    public function getModeReglement(): ?MoyenReglement
    {
        return $this->modeReglement;
    }

    public function setModeReglement(?MoyenReglement $modeReglement): self
    {
        $this->modeReglement = $modeReglement;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getEcheanceAt(): ?\DateTimeImmutable
    {
        return $this->echeanceAt;
    }

    public function setEcheanceAt(\DateTimeImmutable $echeanceAt): self
    {
        $this->echeanceAt = $echeanceAt;

        return $this;
    }
}
