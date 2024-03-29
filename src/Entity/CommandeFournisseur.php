<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CommandeFournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
            normalizationContext: ['groups' => ['read_commande_fournisseur', 'read_commande_fournisseur_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_commande_fournisseur']],
    denormalizationContext: ['groups' => ['write_commande_fournisseur']]
),
]
#[ORM\Entity(repositoryClass: CommandeFournisseurRepository::class)]
class CommandeFournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_commande_fournisseur', 'read_lot', 'read_produit_commande_fournisseur'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_commande_fournisseur', 'read_lot', 'read_produit_commande_fournisseur'])]
    private ?string $numeroCommande = null;

    #[ORM\ManyToOne(inversedBy: 'commandeFournisseurs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_commande_fournisseur', 'read_lot', 'read_produit_commande_fournisseur'])]
    private ?Fournisseur $fournisseur = null;

    #[ORM\Column]
    #[Groups(['read_commande_fournisseur', 'read_lot', 'read_produit_commande_fournisseur'])]
    private ?\DateTimeImmutable $dateCommandeAt = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read_commande_fournisseur', 'read_lot', 'read_produit_commande_fournisseur'])]
    private ?string $observation = null;

    #[ORM\Column]
    #[Groups(['read_commande_fournisseur', 'read_lot', 'read_produit_commande_fournisseur'])]
    private ?bool $etatTraite = null;

    #[ORM\Column]
    #[Groups(['read_commande_fournisseur', 'read_lot', 'read_produit_commande_fournisseur'])]
    private ?bool $etatValide = null;

    #[ORM\Column]
    #[Groups(['read_commande_fournisseur', 'read_lot', 'read_produit_commande_fournisseur'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read_commande_fournisseur', 'read_lot', 'read_produit_commande_fournisseur'])]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_commande_fournisseur', 'read_lot', 'read_produit_commande_fournisseur'])]
    private ?string $numeroFacture = null;

    #[ORM\OneToMany(mappedBy: 'commandeFournisseur', targetEntity: ProduitCommandeFournisseur::class)]
    private Collection $produitCommandeFournisseurs;

    #[ORM\Column(nullable: true)]
    #[Groups(['read_commande_fournisseur', 'read_lot', 'read_produit_commande_fournisseur'])]
    private ?\DateTimeImmutable $dateLivraisonAt = null;

    #[ORM\OneToMany(mappedBy: 'commandeFournisseur', targetEntity: Lot::class)]
    private Collection $lots;

    public function __construct()
    {
        $this->produitCommandeFournisseurs = new ArrayCollection();
        $this->lots = new ArrayCollection();
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

    public function getDateLivraisonAt(): ?\DateTimeImmutable
    {
        return $this->dateLivraisonAt;
    }

    public function setDateLivraisonAt(?\DateTimeImmutable $dateLivraisonAt): self
    {
        $this->dateLivraisonAt = $dateLivraisonAt;

        return $this;
    }

    /**
     * @return Collection<int, Lot>
     */
    public function getLots(): Collection
    {
        return $this->lots;
    }

    public function addLot(Lot $lot): self
    {
        if (!$this->lots->contains($lot)) {
            $this->lots->add($lot);
            $lot->setCommandeFournisseur($this);
        }

        return $this;
    }

    public function removeLot(Lot $lot): self
    {
        if ($this->lots->removeElement($lot)) {
            // set the owning side to null (unless already changed)
            if ($lot->getCommandeFournisseur() === $this) {
                $lot->setCommandeFournisseur(null);
            }
        }

        return $this;
    }
}
