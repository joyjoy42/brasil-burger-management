<?php

namespace App\Entity;

use App\Repository\MenuItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuItemRepository::class)]
#[ORM\Table(name: 'menu_items')]
class MenuItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuItems')]
    #[ORM\JoinColumn(name: 'menu_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Menu $menu = null;

    #[ORM\ManyToOne(targetEntity: Burger::class)]
    #[ORM\JoinColumn(name: 'burger_id', referencedColumnName: 'id')]
    private ?Burger $burger = null;

    #[ORM\ManyToOne(targetEntity: Complement::class)]
    #[ORM\JoinColumn(name: 'complement_id', referencedColumnName: 'id')]
    private ?Complement $complement = null;

    #[ORM\Column(name: 'item_price', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $itemPrice = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): static
    {
        $this->burger = $burger;

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

    public function getItemPrice(): ?string
    {
        return $this->itemPrice;
    }

    public function setItemPrice(?string $itemPrice): static
    {
        $this->itemPrice = $itemPrice;

        return $this;
    }
}
