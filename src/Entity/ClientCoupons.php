<?php

namespace App\Entity;

use App\Repository\ClientCouponsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientCouponsRepository::class)]
class ClientCoupons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'clientCoupons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'clientCoupons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Coupons $coupon = null;

    #[ORM\Column]
    private ?int $montantUtilise = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

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
}
