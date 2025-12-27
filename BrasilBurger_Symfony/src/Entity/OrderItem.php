<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
#[ORM\Table(name: 'lignes_commande')]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'orderItems')]
    #[ORM\JoinColumn(name: 'commande_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Order $order = null;

    #[ORM\ManyToOne(targetEntity: Burger::class)]
    #[ORM\JoinColumn(name: 'produit_id', referencedColumnName: 'id')]
    private ?Burger $burger = null;

    #[ORM\ManyToOne(targetEntity: Menu::class)]
    #[ORM\JoinColumn(name: 'produit_id', referencedColumnName: 'id')]
    private ?Menu $menu = null;

    #[ORM\ManyToOne(targetEntity: Complement::class)]
    #[ORM\JoinColumn(name: 'produit_id', referencedColumnName: 'id')]
    private ?Complement $complement = null;

    #[ORM\Column(name: 'type_produit', length: 20, nullable: true)]
    private ?string $productType = null; // 'burger', 'menu', 'complement'

    #[ORM\Column(name: 'quantite')]
    private ?int $quantity = 1;

    #[ORM\Column(name: 'prix_unitaire', type: 'decimal', precision: 10, scale: 2)]
    private ?string $unitPrice = null;

    #[ORM\Column(name: 'complements', type: 'text', nullable: true)]
    private ?string $complementsData = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): static
    {
        $this->burger = $burger;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): static
    {
        $this->menu = $menu;

        return $this;
    }

    public function getComplement(): ?Complement
    {
        return $this->complement;
    }

    public function setComplement(?Complement $complement): static
    {
        $this->complement = $complement;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPrice(): ?string
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(string $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getProductType(): ?string
    {
        return $this->productType;
    }

    public function setProductType(?string $productType): static
    {
        $this->productType = $productType;

        return $this;
    }

    public function getComplementsData(): ?string
    {
        return $this->complementsData;
    }

    public function setComplementsData(?string $complementsData): static
    {
        $this->complementsData = $complementsData;

        return $this;
    }
}
