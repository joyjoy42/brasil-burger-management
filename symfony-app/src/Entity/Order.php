<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'commandes')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id')]
    private ?User $client = null;

    #[ORM\ManyToOne(targetEntity: Zone::class)]
    #[ORM\JoinColumn(name: 'zone_id', referencedColumnName: 'id', nullable: true)]
    private ?Zone $zone = null;

    #[ORM\Column(name: 'date_commande', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(type: 'string', columnDefinition: 'order_status', options: ['default' => 'PENDING'])]
    private ?string $etat = null;

    #[ORM\Column(name: 'type_commande', type: 'string', columnDefinition: 'order_type')]
    private ?string $typeCommande = null;

    #[ORM\Column(name: 'prix_total', type: 'decimal', precision: 10, scale: 2)]
    private ?string $prixTotal = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'livreur_id', referencedColumnName: 'id', nullable: true)]
    private ?User $livreur = null;

    public function getId(): ?int { return $this->id; }
    public function getEtat(): ?string { return $this->etat; }
    public function setEtat(string $etat): self { $this->etat = $etat; return $this; }
    public function getPrixTotal(): ?string { return $this->prixTotal; }
    public function getDateCommande(): ?\DateTimeInterface { return $this->dateCommande; }
}
