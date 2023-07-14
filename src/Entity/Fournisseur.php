<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\FournisseurRepository;
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
            normalizationContext: ['groups' => ['read_fournisseur', 'read_fournisseur_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_fournisseur']],
    denormalizationContext: ['groups' => ['write_fournisseur']]
),
]
#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_fournisseur', 'read_commande_fournisseur'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_fournisseur', 'read_commande_fournisseur'])]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_fournisseur', 'read_commande_fournisseur'])]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_fournisseur', 'read_commande_fournisseur'])]
    private ?string $entreprise = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_fournisseur', 'read_commande_fournisseur'])]
    private ?string $responsable = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_fournisseur', 'read_commande_fournisseur'])]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_fournisseur', 'read_commande_fournisseur'])]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_fournisseur', 'read_commande_fournisseur'])]
    private ?string $tel = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_fournisseur', 'read_commande_fournisseur'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_fournisseur', 'read_commande_fournisseur'])]
    private ?string $matfiscal = null;

    #[ORM\Column]
    #[Groups(['read_fournisseur', 'read_commande_fournisseur'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['read_fournisseur', 'read_commande_fournisseur'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'fournisseur', targetEntity: CommandeFournisseur::class)]
    private Collection $commandeFournisseurs;

    public function __construct()
    {
        $this->commandeFournisseurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(string $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMatfiscal(): ?string
    {
        return $this->matfiscal;
    }

    public function setMatfiscal(string $matfiscal): self
    {
        $this->matfiscal = $matfiscal;

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

    /**
     * @return Collection<int, CommandeFournisseur>
     */
    public function getCommandeFournisseurs(): Collection
    {
        return $this->commandeFournisseurs;
    }

    public function addCommandeFournisseur(CommandeFournisseur $commandeFournisseur): self
    {
        if (!$this->commandeFournisseurs->contains($commandeFournisseur)) {
            $this->commandeFournisseurs->add($commandeFournisseur);
            $commandeFournisseur->setFournisseur($this);
        }

        return $this;
    }

    public function removeCommandeFournisseur(CommandeFournisseur $commandeFournisseur): self
    {
        if ($this->commandeFournisseurs->removeElement($commandeFournisseur)) {
            // set the owning side to null (unless already changed)
            if ($commandeFournisseur->getFournisseur() === $this) {
                $commandeFournisseur->setFournisseur(null);
            }
        }

        return $this;
    }
}
