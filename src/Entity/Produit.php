<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $prixAchat = null;

    #[ORM\Column]
    private ?int $prixVente = null;

    #[ORM\Column]
    private ?float $tva = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroArticle = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: ProduitCommandeClient::class)]
    private Collection $produitCommandeClients;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: ProduitCommandeFournisseur::class)]
    private Collection $produitCommandeFournisseurs;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $datePeremptionAt = null;

    #[ORM\OneToMany(mappedBy: 'produits', targetEntity: Sorties::class)]
    private Collection $sorties;

    public function __construct()
    {
        $this->produitCommandeClients = new ArrayCollection();
        $this->produitCommandeFournisseurs = new ArrayCollection();
        $this->sorties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrixAchat(): ?int
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(int $prixAchat): self
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    public function getPrixVente(): ?int
    {
        return $this->prixVente;
    }

    public function setPrixVente(int $prixVente): self
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getNumeroArticle(): ?string
    {
        return $this->numeroArticle;
    }

    public function setNumeroArticle(string $numeroArticle): self
    {
        $this->numeroArticle = $numeroArticle;

        return $this;
    }

    /**
     * @return Collection<int, ProduitCommandeClient>
     */
    public function getProduitCommandeClients(): Collection
    {
        return $this->produitCommandeClients;
    }

    public function addProduitCommandeClient(ProduitCommandeClient $produitCommandeClient): self
    {
        if (!$this->produitCommandeClients->contains($produitCommandeClient)) {
            $this->produitCommandeClients->add($produitCommandeClient);
            $produitCommandeClient->setProduit($this);
        }

        return $this;
    }

    public function removeProduitCommandeClient(ProduitCommandeClient $produitCommandeClient): self
    {
        if ($this->produitCommandeClients->removeElement($produitCommandeClient)) {
            // set the owning side to null (unless already changed)
            if ($produitCommandeClient->getProduit() === $this) {
                $produitCommandeClient->setProduit(null);
            }
        }

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
            $produitCommandeFournisseur->setProduit($this);
        }

        return $this;
    }

    public function removeProduitCommandeFournisseur(ProduitCommandeFournisseur $produitCommandeFournisseur): self
    {
        if ($this->produitCommandeFournisseurs->removeElement($produitCommandeFournisseur)) {
            // set the owning side to null (unless already changed)
            if ($produitCommandeFournisseur->getProduit() === $this) {
                $produitCommandeFournisseur->setProduit(null);
            }
        }

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

    /**
     * @return Collection<int, Sorties>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sorties $sorty): self
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties->add($sorty);
            $sorty->setProduits($this);
        }

        return $this;
    }

    public function removeSorty(Sorties $sorty): self
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getProduits() === $this) {
                $sorty->setProduits(null);
            }
        }

        return $this;
    }
}
