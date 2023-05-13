<?php

namespace App\Entity;

use App\Repository\CommandeFournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeFournisseurRepository::class)]
class CommandeFournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroCommande = null;

    #[ORM\ManyToOne(inversedBy: 'commandeFournisseurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fournisseur $fournisseur = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateCommandeAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $observation = null;

    #[ORM\Column]
    private ?bool $etatTraite = null;

    #[ORM\Column]
    private ?bool $etatValide = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroFacture = null;

    #[ORM\OneToMany(mappedBy: 'commandeFournisseur', targetEntity: ProduitCommandeFournisseur::class)]
    private Collection $produitCommandeFournisseurs;

    public function __construct()
    {
        $this->produitCommandeFournisseurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getDateCommandeAt(): ?\DateTimeImmutable
    {
        return $this->dateCommandeAt;
    }

    public function setDateCommandeAt(\DateTimeImmutable $dateCommandeAt): self
    {
        $this->dateCommandeAt = $dateCommandeAt;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(string $observation): self
    {
        $this->observation = $observation;

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

    public function isEtatValide(): ?bool
    {
        return $this->etatValide;
    }

    public function setEtatValide(bool $etatValide): self
    {
        $this->etatValide = $etatValide;

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

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getNumeroFacture(): ?string
    {
        return $this->numeroFacture;
    }

    public function setNumeroFacture(string $numeroFacture): self
    {
        $this->numeroFacture = $numeroFacture;

        return $this;
    }

    /**
     * @return Collection<int, ProduitCommandeFournisseur>
     */
    public function getProduitCommandeFournisseurs(): Collection
    {
        return $this->produitCommandeFournisseurs;
    }

    public function addProduitCommandeFournisseur(ProduitCommandeFournisseur $produitCommandeFournisseur): self
    {
        if (!$this->produitCommandeFournisseurs->contains($produitCommandeFournisseur)) {
            $this->produitCommandeFournisseurs->add($produitCommandeFournisseur);
            $produitCommandeFournisseur->setCommandeFournisseur($this);
        }

        return $this;
    }

    public function removeProduitCommandeFournisseur(ProduitCommandeFournisseur $produitCommandeFournisseur): self
    {
        if ($this->produitCommandeFournisseurs->removeElement($produitCommandeFournisseur)) {
            // set the owning side to null (unless already changed)
            if ($produitCommandeFournisseur->getCommandeFournisseur() === $this) {
                $produitCommandeFournisseur->setCommandeFournisseur(null);
            }
        }

        return $this;
    }
}
