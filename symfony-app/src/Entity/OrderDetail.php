<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'commande_details')]
class OrderDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    #[ORM\JoinColumn(name: 'commande_id', referencedColumnName: 'id')]
    private ?Order $commande = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: true)]
    private ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: Menu::class)]
    #[ORM\JoinColumn(name: 'menu_id', referencedColumnName: 'id', nullable: true)]
    private ?Menu $menu = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(name: 'prix_unitaire', type: 'decimal', precision: 10, scale: 2)]
    private ?string $prixUnitaire = null;

    public function getId(): ?int { return $this->id; }
    public function getQuantite(): ?int { return $this->quantite; }
    public function getPrixUnitaire(): ?string { return $this->prixUnitaire; }
}
