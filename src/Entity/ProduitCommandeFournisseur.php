<?php

namespace App\Entity;

use App\Repository\ProduitCommandeFournisseurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitCommandeFournisseurRepository::class)]
class ProduitCommandeFournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'produitCommandeFournisseurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $produit = null;

    #[ORM\ManyToOne(inversedBy: 'produitCommandeFournisseurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CommandeFournisseur $commandeFournisseur = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroCommande = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?bool $etatTraite = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantiteLivree = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantiteUpdate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $datePeremptionAt = null;

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

    public function getCommandeFournisseur(): ?CommandeFournisseur
    {
        return $this->commandeFournisseur;
    }

    public function setCommandeFournisseur(?CommandeFournisseur $commandeFournisseur): self
    {
        $this->commandeFournisseur = $commandeFournisseur;

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

    public function setQuantiteLivree(int $quantiteLivree): self
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

    public function getDatePeremptionAt(): ?\DateTimeImmutable
    {
        return $this->datePeremptionAt;
    }

    public function setDatePeremptionAt(?\DateTimeImmutable $datePeremptionAt): self
    {
        $this->datePeremptionAt = $datePeremptionAt;

        return $this;
    }
}
