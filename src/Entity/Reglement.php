<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ReglementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource
(
    operations: [
        new Post(),
        new Put(),
        new Delete(),
        new Get(
            normalizationContext: ['groups' => ['read_reglement', 'read_reglement_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_reglement']],
    denormalizationContext: ['groups' => ['write_reglement']]
),
]
#[ORM\Entity(repositoryClass: ReglementRepository::class)]
class Reglement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_reglement'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_reglement'])]
    private ?CommandeClient $commandeClient = null;

    #[ORM\ManyToOne(inversedBy: 'reglements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_reglement'])]
    private ?MoyenReglement $modeReglement = null;

    #[ORM\Column]
    #[Groups(['read_reglement'])]
    private ?int $montant = null;

    #[ORM\Column]
    #[Groups(['read_reglement'])]
    private ?String $echeanceAt = null;

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

    public function getEcheanceAt(): ?String
    {
        return $this->echeanceAt;
    }

    public function setEcheanceAt(String $echeanceAt): self
    {
        $this->echeanceAt = $echeanceAt;

        return $this;
    }
}
