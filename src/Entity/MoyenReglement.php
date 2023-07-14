<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\MoyenReglementRepository;
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
            normalizationContext: ['groups' => ['read_moyen_reglement', 'read_moyen_reglement_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_moyen_reglement']],
    denormalizationContext: ['groups' => ['write_moyen_reglement']]
),
]
#[ORM\Entity(repositoryClass: MoyenReglementRepository::class)]
class MoyenReglement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_moyen_reglement', 'read_commande_client', 'read_reglement'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_moyen_reglement', 'read_commande_client', 'read_reglement'])]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'modeReglement', targetEntity: Reglement::class)]
    private Collection $reglements;

    #[ORM\OneToMany(mappedBy: 'moyenPaiement', targetEntity: CommandeClient::class)]
    private Collection $commandeClients;

    public function __construct()
    {
        $this->reglements = new ArrayCollection();
        $this->commandeClients = new ArrayCollection();
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
            $reglement->setModeReglement($this);
        }

        return $this;
    }

    public function removeReglement(Reglement $reglement): self
    {
        if ($this->reglements->removeElement($reglement)) {
            // set the owning side to null (unless already changed)
            if ($reglement->getModeReglement() === $this) {
                $reglement->setModeReglement(null);
            }
        }

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
            $commandeClient->setMoyenPaiement($this);
        }

        return $this;
    }

    public function removeCommandeClient(CommandeClient $commandeClient): self
    {
        if ($this->commandeClients->removeElement($commandeClient)) {
            // set the owning side to null (unless already changed)
            if ($commandeClient->getMoyenPaiement() === $this) {
                $commandeClient->setMoyenPaiement(null);
            }
        }

        return $this;
    }
}
