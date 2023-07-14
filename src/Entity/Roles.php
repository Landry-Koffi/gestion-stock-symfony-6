<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\RolesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource
(
    operations: [
        new Post(),
        new Put(),
        new Delete(),
        new Get(
            normalizationContext: ['groups' => ['read_roles', 'read_roles_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_roles']],
    denormalizationContext: ['groups' => ['write_roles']]
),
]
#[ORM\Entity(repositoryClass: RolesRepository::class)]
class Roles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_roles'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_roles'])]
    private ?string $libelle = null;

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
}
