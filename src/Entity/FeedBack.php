<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\FeedBackRepository;
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
            normalizationContext: ['groups' => ['read_feed_back', 'read_feed_back_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_feed_back']],
    denormalizationContext: ['groups' => ['write_feed_back']]
),
]
#[ORM\Entity(repositoryClass: FeedBackRepository::class)]
class FeedBack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_feed_back'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'feedBacks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_feed_back'])]
    private ?Client $client = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_feed_back'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read_feed_back'])]
    private ?string $content = null;

    #[ORM\Column]
    #[Groups(['read_feed_back'])]
    private ?\DateTimeImmutable $createdAt = null;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
}
