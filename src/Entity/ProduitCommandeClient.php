<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ProduitCommandeClientRepository;
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
            normalizationContext: ['groups' => ['read_produit_commande_client', 'read_produit_commande_client_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_produit_commande_client']],
    denormalizationContext: ['groups' => ['write_produit_commande_client']]
),
]
#[ORM\Entity(repositoryClass: ProduitCommandeClientRepository::class)]
class ProduitCommandeClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_produit_commande_client'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'produitCommandeClients')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_produit_commande_client'])]
    private ?Produit $produit = null;

    #[ORM\ManyToOne(inversedBy: 'produitCommandeClients')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_produit_commande_client'])]
    private ?CommandeClient $commandeClient = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_produit_commande_client'])]
    private ?string $numeroCommande = null;

    #[ORM\Column]
    #[Groups(['read_produit_commande_client'])]
    private ?int $quantite = null;

    #[ORM\Column]
    #[Groups(['read_produit_commande_client'])]
    private ?int $prixTotal = null;

    #[ORM\Column]
    #[Groups(['read_produit_commande_client'])]
    private ?bool $etatTraite = null;

    #[ORM\Column]
    #[Groups(['read_produit_commande_client'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['read_produit_commande_client'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read_produit_commande_client'])]
    private ?int $quantiteLivree = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read_produit_commande_client'])]
    private ?int $quantiteUpdate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read_produit_commande_client'])]
    private ?string $commentaire = null;

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

    public function getCommandeClient(): ?CommandeClient
    {
        return $this->commandeClient;
    }

    public function setCommandeClient(?CommandeClient $commandeClient): self
    {
        $this->commandeClient = $commandeClient;

        return $this;
    }

    public function getNumeroCommande(): ?string
    {
        return $this->numeroCommande;
    }

    public function setNumeroCommande(string $numeroCommande): self
    {
        $this->numeroCommande = $numeroCommande;

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

    public function getPrixTotal(): ?int
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(int $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function isEtatTraite(): ?bool
    {
        return $this->etatTraite;
    }

    public function setEtatTraite(bool $etatTraite): self
    {
        $this->etatTraite = $etatTraite;

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

    public function getQuantiteLivree(): ?int
    {
        return $this->quantiteLivree;
    }

    public function setQuantiteLivree(?int $quantiteLivree): self
    {
        $this->quantiteLivree = $quantiteLivree;

        return $this;
    }

    public function getQuantiteUpdate(): ?int
    {
        return $this->quantiteUpdate;
    }

    public function setQuantiteUpdate(?int $quantiteUpdate): self
    {
        $this->quantiteUpdate = $quantiteUpdate;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }
}
