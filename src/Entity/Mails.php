<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\MailsRepository;
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
            normalizationContext: ['groups' => ['read_mails', 'read_mails_item']]
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['read_mails']],
    denormalizationContext: ['groups' => ['write_mails']]
),
]
#[ORM\Entity(repositoryClass: MailsRepository::class)]
class Mails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_mails'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_mails'])]
    private ?string $emailSender = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_mails'])]
    private ?string $emailReceive = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_mails'])]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read_mails'])]
    private ?string $content = null;

    #[ORM\Column]
    #[Groups(['read_mails'])]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailSender(): ?string
    {
        return $this->emailSender;
    }

    public function setEmailSender(string $emailSender): self
    {
        $this->emailSender = $emailSender;

        return $this;
    }

    public function getEmailReceive(): ?string
    {
        return $this->emailReceive;
    }

    public function setEmailReceive(string $emailReceive): self
    {
        $this->emailReceive = $emailReceive;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

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
