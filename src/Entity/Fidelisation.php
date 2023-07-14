<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\FidelisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource
(
    operations: [
        new Post(),
        new Put(),
        new Delete(),
        new Get(
            normalizationContext: ['groups' => ['read_fidelisation', 'read_fidelisation_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_fidelisation']],
    denormalizationContext: ['groups' => ['write_fidelisation']]
),
]
#[ORM\Entity(repositoryClass: FidelisationRepository::class)]
class Fidelisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_fidelisation'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fidelisations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_fidelisation'])]
    private ?Client $client = null;

    #[ORM\Column]
    #[Groups(['read_fidelisation'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['read_fidelisation'])]
    private ?bool $etat = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read_fidelisation'])]
    private ?int $monnaie = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read_fidelisation'])]
    private ?int $points = null;

    public function __construct()
    {
        $this->monnaies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMonnaie(): ?int
    {
        return $this->monnaie;
    }

    public function setMonnaie(?int $monnaie): self
    {
        $this->monnaie = $monnaie;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }
}
