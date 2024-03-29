<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CommandeClientRepository;
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
            normalizationContext: ['groups' => ['read_commande_client', 'read_commande_client_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_commande_client']],
    denormalizationContext: ['groups' => ['write_commande_client']]
),
]
#[ORM\Entity(repositoryClass: CommandeClientRepository::class)]
class CommandeClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?string $numeroCommande = null;

    #[ORM\ManyToOne(inversedBy: 'commandeClients')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?Client $client = null;

    #[ORM\Column]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?\DateTimeImmutable $dateCommandeAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?string $observation = null;

    #[ORM\Column]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?int $totalHt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?int $totalTva = null;

    #[ORM\Column]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?int $totalTtc = null;

    #[ORM\Column]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?bool $etatTraite = null;

    #[ORM\Column]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?bool $etatValide = null;

    #[ORM\Column]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?string $numeroFacture = null;

    #[ORM\OneToMany(mappedBy: 'commandeClient', targetEntity: Reglement::class)]
    private Collection $reglements;

    #[ORM\OneToMany(mappedBy: 'commandeClient', targetEntity: ProduitCommandeClient::class)]
    private Collection $produitCommandeClients;

    #[ORM\Column(nullable: true)]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?\DateTimeImmutable $dateLivraisonAt = null;

    /*#[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?string $echeance = null;*/

    #[ORM\ManyToOne(inversedBy: 'commandeClients')]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?MoyenReglement $moyenPaiement = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read_commande_client', 'read_produit_commande_client', 'read_reglement'])]
    private ?int $coupon = null;

    public function __construct()
    {
        $this->reglements = new ArrayCollection();
        $this->produitCommandeClients = new ArrayCollection();
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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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

    public function getTotalHt(): ?int
    {
        return $this->totalHt;
    }

    public function setTotalHt(int $totalHt): self
    {
        $this->totalHt = $totalHt;

        return $this;
    }

    public function getTotalTva(): ?int
    {
        return $this->totalTva;
    }

    public function setTotalTva(int $totalTva): self
    {
        $this->totalTva = $totalTva;

        return $this;
    }

    public function getTotalTtc(): ?int
    {
        return $this->totalTtc;
    }

    public function setTotalTtc(int $totalTtc): self
    {
        $this->totalTtc = $totalTtc;

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
     * @return Collection<int, Reglement>
     */
    public function getReglements(): Collection
    {
        return $this->reglements;
    }

    public function addReglement(Reglement $reglement): self
    {
        if (!$this->reglements->contains($reglement)) {
            $this->reglements->add($reglement);
            $reglement->setCommandeClient($this);
        }

        return $this;
    }

    public function removeReglement(Reglement $reglement): self
    {
        if ($this->reglements->removeElement($reglement)) {
            // set the owning side to null (unless already changed)
            if ($reglement->getCommandeClient() === $this) {
                $reglement->setCommandeClient(null);
            }
        }

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
            $produitCommandeClient->setCommandeClient($this);
        }

        return $this;
    }

    public function removeProduitCommandeClient(ProduitCommandeClient $produitCommandeClient): self
    {
        if ($this->produitCommandeClients->removeElement($produitCommandeClient)) {
            // set the owning side to null (unless already changed)
            if ($produitCommandeClient->getCommandeClient() === $this) {
                $produitCommandeClient->setCommandeClient(null);
            }
        }

        return $this;
    }

    public function getDateLivraisonAt(): ?\DateTimeImmutable
    {
        return $this->dateLivraisonAt;
    }

    public function setDateLivraisonAt(\DateTimeImmutable $dateLivraisonAt): self
    {
        $this->dateLivraisonAt = $dateLivraisonAt;

        return $this;
    }

    /*public function getEcheance(): ?string
    {
        return $this->echeance;
    }

    public function setEcheance(?string $echeance): self
    {
        $this->echeance = $echeance;

        return $this;
    }*/

    public function getMoyenPaiement(): ?MoyenReglement
    {
        return $this->moyenPaiement;
    }

    public function setMoyenPaiement(?MoyenReglement $moyenPaiement): self
    {
        $this->moyenPaiement = $moyenPaiement;

        return $this;
    }

    public function getCoupon(): ?int
    {
        return $this->coupon;
    }

    public function setCoupon(?int $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }
}
