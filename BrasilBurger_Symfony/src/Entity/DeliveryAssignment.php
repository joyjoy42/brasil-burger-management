<?php

namespace App\Entity;

use App\Repository\DeliveryAssignmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeliveryAssignmentRepository::class)]
#[ORM\Table(name: 'delivery_assignments')]
class DeliveryAssignment
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: Order::class)]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', unique: true)]
    private ?Order $order = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'livrer_id', referencedColumnName: 'id')]
    private ?User $livreur = null;

    #[ORM\Column(name: 'assigned_at', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $assignedAt = null;

    public function __construct()
    {
        $this->assignedAt = new \DateTime();
    }

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

    public function getLivreur(): ?User
    {
        return $this->livreur;
    }

    public function setLivreur(?User $livreur): static
    {
        $this->livreur = $livreur;

        return $this;
    }

    public function getAssignedAt(): ?\DateTimeInterface
    {
        return $this->assignedAt;
    }

    public function setAssignedAt(\DateTimeInterface $assignedAt): static
    {
        $this->assignedAt = $assignedAt;

        return $this;
    }
}
