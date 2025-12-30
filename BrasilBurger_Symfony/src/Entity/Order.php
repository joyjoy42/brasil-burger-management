<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'commandes')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'client_id')]
    private ?int $clientId = null;

    #[ORM\Column(name: 'type_livraison', length: 20)]
    private ?string $typeLivraison = null;

    #[ORM\Column(name: 'etat', length: 50)]
    private ?string $etat = null;

    #[ORM\Column(name: 'montant_total', type: 'decimal', precision: 10, scale: 2)]
    private ?string $montantTotal = null;

    #[ORM\Column(name: 'zone_id', nullable: true)]
    private ?int $zoneId = null;

    #[ORM\Column(name: 'date_commande', type: 'datetime')]
    private ?\DateTimeInterface $dateCommande = null;

    public function getId(): ?int { return $this->id; }
    public function getClientId(): ?int { return $this->clientId; }
    public function setClientId(int $clientId): self { $this->clientId = $clientId; return $this; }
    public function getTypeLivraison(): ?string { return $this->typeLivraison; }
    public function setTypeLivraison(string $typeLivraison): self { $this->typeLivraison = $typeLivraison; return $this; }
    public function getEtat(): ?string { return $this->etat; }
    public function setEtat(string $etat): self { $this->etat = $etat; return $this; }
    public function getMontantTotal(): ?string { return $this->montantTotal; }
    public function setMontantTotal(string $montantTotal): self { $this->montantTotal = $montantTotal; return $this; }
    public function getZoneId(): ?int { return $this->zoneId; }
    public function setZoneId(?int $zoneId): self { $this->zoneId = $zoneId; return $this; }
    public function getDateCommande(): ?\DateTimeInterface { return $this->dateCommande; }
    public function setDateCommande(\DateTimeInterface $dateCommande): self { $this->dateCommande = $dateCommande; return $this; }
}
