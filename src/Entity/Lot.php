<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\LotRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource
(
    operations: [
        new Post(),
        new Put(),
        new Delete(),
        new Get(
            normalizationContext: ['groups' => ['read_lot', 'read_lot_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_lot']],
    denormalizationContext: ['groups' => ['write_lot']]
),
]
#[ORM\Entity(repositoryClass: LotRepository::class)]
class Lot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_lot'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'lots')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_lot'])]
    private ?Produit $produit = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read_lot'])]
    private ?\DateTimeImmutable $datePeremptionAt = null;

    #[ORM\Column]
    #[Groups(['read_lot'])]
    private ?int $stock = null;

    #[ORM\ManyToOne(inversedBy: 'lots')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_lot'])]
    private ?CommandeFournisseur $commandeFournisseur = null;

    #[ORM\Column]
    #[Groups(['read_lot'])]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getDatePeremptionAt(): ?\DateTimeImmutable
    {
        return $this->datePeremptionAt;
    }

    public function setDatePeremptionAt(?\DateTimeImmutable $datePeremptionAt): self
    {
        $this->datePeremptionAt = $datePeremptionAt;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCommandeFournisseur(): ?CommandeFournisseur
    {
        return $this->commandeFournisseur;
    }

    public function setCommandeFournisseur(?CommandeFournisseur $commandeFournisseur): self
    {
        $this->commandeFournisseur = $commandeFournisseur;

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
}
