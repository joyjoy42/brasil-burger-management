<?php

namespace App\Entity;

use App\Repository\ZoneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ORM\Table(name: 'zones')]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $neighborhoods = null;

    #[ORM\Column(name: 'delivery_price', type: 'decimal', precision: 10, scale: 2, options: ['default' => '0.00'])]
    private ?string $deliveryPrice = '0.00';

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

    public function getNeighborhoods(): ?string
    {
        return $this->neighborhoods;
    }

    public function setNeighborhoods(?string $neighborhoods): static
    {
        $this->neighborhoods = $neighborhoods;

        return $this;
    }

    public function getDeliveryPrice(): ?string
    {
        return $this->deliveryPrice;
    }

    public function setDeliveryPrice(string $deliveryPrice): static
    {
        $this->deliveryPrice = $deliveryPrice;

        return $this;
    }
}
