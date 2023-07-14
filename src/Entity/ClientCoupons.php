<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ClientCouponsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource
(
    operations: [
        new Post(),
        new Put(),
        new Delete(),
        new Get(
            normalizationContext: ['groups' => ['read_clientCoupons', 'read_clientCoupons_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_clientCoupons']],
    denormalizationContext: ['groups' => ['write_clientCoupons']]
),
]
#[ORM\Entity(repositoryClass: ClientCouponsRepository::class)]
class ClientCoupons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_clientCoupons'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'clientCoupons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_clientCoupons'])]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'clientCoupons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_clientCoupons'])]
    private ?Coupons $coupon = null;

    #[ORM\Column]
    #[Groups(['read_clientCoupons'])]
    private ?int $montantUtilise = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?bool $etat = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCoupon(): ?Coupons
    {
        return $this->coupon;
    }

    public function setCoupon(?Coupons $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function getMontantUtilise(): ?int
    {
        return $this->montantUtilise;
    }

    public function setMontantUtilise(int $montantUtilise): self
    {
        $this->montantUtilise = $montantUtilise;

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

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
