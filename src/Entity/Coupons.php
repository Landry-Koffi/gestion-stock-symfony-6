<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CouponsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource
(
    operations: [
        new Post(),
        new Put(),
        new Delete(),
        new Get(
            normalizationContext: ['groups' => ['read_coupons', 'read_coupons_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_coupons']],
    denormalizationContext: ['groups' => ['write_coupons']]
),
]
#[ORM\Entity(repositoryClass: CouponsRepository::class)]
#[UniqueEntity('libelle', message: 'Ce libellé existe déjà')]
class Coupons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_coupons'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_coupons'])]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['read_coupons'])]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column]
    #[Groups(['read_coupons'])]
    private ?bool $etat = null;

    #[ORM\Column]
    #[Groups(['read_coupons'])]
    private ?int $montant = null;

    #[ORM\OneToMany(mappedBy: 'coupon', targetEntity: ClientCoupons::class)]
    private Collection $clientCoupons;

    public function __construct()
    {
        $this->clientCoupons = new ArrayCollection();
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

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

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

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * @return Collection<int, ClientCoupons>
     */
    public function getClientCoupons(): Collection
    {
        return $this->clientCoupons;
    }

    public function addClientCoupon(ClientCoupons $clientCoupon): self
    {
        if (!$this->clientCoupons->contains($clientCoupon)) {
            $this->clientCoupons->add($clientCoupon);
            $clientCoupon->setCoupon($this);
        }

        return $this;
    }

    public function removeClientCoupon(ClientCoupons $clientCoupon): self
    {
        if ($this->clientCoupons->removeElement($clientCoupon)) {
            // set the owning side to null (unless already changed)
            if ($clientCoupon->getCoupon() === $this) {
                $clientCoupon->setCoupon(null);
            }
        }

        return $this;
    }
}
