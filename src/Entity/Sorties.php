<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\SortiesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource
(
    operations: [
        new Post(),
        new Put(),
        new Delete(),
        new Get(
            normalizationContext: ['groups' => ['read_sorties', 'read_sorties_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_sorties']],
    denormalizationContext: ['groups' => ['write_sorties']]
),
]
#[ORM\Entity(repositoryClass: SortiesRepository::class)]
class Sorties
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_sorties'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_sorties'])]
    private ?Produit $produits = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read_sorties'])]
    private ?string $motif = null;

    #[ORM\Column]
    #[Groups(['read_sorties'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_sorties'])]
    private ?Users $admin = null;

    #[ORM\Column]
    #[Groups(['read_sorties'])]
    private ?int $quantite = null;

    #[ORM\Column]
    #[Groups(['read_sorties'])]
    private ?int $prixUnitaire = null;

    #[ORM\Column]
    #[Groups(['read_sorties'])]
    private ?int $prixTotal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduits(): ?Produit
    {
        return $this->produits;
    }

    public function setProduits(?Produit $produits): self
    {
        $this->produits = $produits;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

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

    public function getAdmin(): ?Users
    {
        return $this->admin;
    }

    public function setAdmin(?Users $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixUnitaire(): ?int
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(int $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getPrixTotal(): ?int
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(int $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }
}
