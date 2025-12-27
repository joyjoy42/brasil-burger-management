<?php

namespace App\Entity;

use App\Repository\ComplementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ORM\Table(name: 'complements')]
class Complement
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'nom', length: 150)]
    private ?string $name = null;

    #[ORM\Column(name: 'type', length: 50, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(name: 'prix', type: 'decimal', precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(name: 'image', type: 'string', nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column(name: 'archive', options: ['default' => false])]
    private ?bool $archived = false;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function isArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): static
    {
        $this->archived = $archived;

        return $this;
    }
}
