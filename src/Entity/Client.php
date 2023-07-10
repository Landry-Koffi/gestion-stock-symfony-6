<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[UniqueEntity('tel', message: 'Ce numéro de téléphone est déjà utilisé')]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $responsable = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $tel = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $matfiscal = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: CommandeClient::class)]
    private Collection $commandeClients;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Fidelisation::class)]
    private Collection $fidelisations;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: FeedBack::class)]
    private Collection $feedBacks;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: ClientCoupons::class)]
    private Collection $clientCoupons;

    public function __construct()
    {
        $this->commandeClients = new ArrayCollection();
        $this->fidelisations = new ArrayCollection();
        $this->feedBacks = new ArrayCollection();
        $this->clientCoupons = new ArrayCollection();
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

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * @return Collection<int, CommandeClient>
     */
    public function getCommandeClients(): Collection
    {
        return $this->commandeClients;
    }

    public function addCommandeClient(CommandeClient $commandeClient): self
    {
        if (!$this->commandeClients->contains($commandeClient)) {
            $this->commandeClients->add($commandeClient);
            $commandeClient->setClient($this);
        }

        return $this;
    }

    public function removeCommandeClient(CommandeClient $commandeClient): self
    {
        if ($this->commandeClients->removeElement($commandeClient)) {
            // set the owning side to null (unless already changed)
            if ($commandeClient->getClient() === $this) {
                $commandeClient->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Fidelisation>
     */
    public function getFidelisations(): Collection
    {
        return $this->fidelisations;
    }

    public function addFidelisation(Fidelisation $fidelisation): self
    {
        if (!$this->fidelisations->contains($fidelisation)) {
            $this->fidelisations->add($fidelisation);
            $fidelisation->setClient($this);
        }

        return $this;
    }

    public function removeFidelisation(Fidelisation $fidelisation): self
    {
        if ($this->fidelisations->removeElement($fidelisation)) {
            // set the owning side to null (unless already changed)
            if ($fidelisation->getClient() === $this) {
                $fidelisation->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FeedBack>
     */
    public function getFeedBacks(): Collection
    {
        return $this->feedBacks;
    }

    public function addFeedBack(FeedBack $feedBack): self
    {
        if (!$this->feedBacks->contains($feedBack)) {
            $this->feedBacks->add($feedBack);
            $feedBack->setClient($this);
        }

        return $this;
    }

    public function removeFeedBack(FeedBack $feedBack): self
    {
        if ($this->feedBacks->removeElement($feedBack)) {
            // set the owning side to null (unless already changed)
            if ($feedBack->getClient() === $this) {
                $feedBack->setClient(null);
            }
        }

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
            $clientCoupon->setClient($this);
        }

        return $this;
    }

    public function removeClientCoupon(ClientCoupons $clientCoupon): self
    {
        if ($this->clientCoupons->removeElement($clientCoupon)) {
            // set the owning side to null (unless already changed)
            if ($clientCoupon->getClient() === $this) {
                $clientCoupon->setClient(null);
            }
        }

        return $this;
    }
}
