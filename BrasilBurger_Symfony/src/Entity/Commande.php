<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    public const TYPE_SUR_PLACE = 'sur_place';
    public const TYPE_A_EMPORTER = 'a_emporter';
    public const TYPE_LIVRAISON = 'livraison';

    public const STATUT_EN_ATTENTE = 'en_attente';
    public const STATUT_VALIDE = 'valide';
    public const STATUT_PREPARATION = 'preparation';
    public const STATUT_PRETE = 'prete';
    public const STATUT_TERMINE = 'termine';
    public const STATUT_ANNULE = 'annule';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\Column(length: 20)]
    private ?string $typeCommande = null;

    #[ORM\Column(length: 20)]
    private ?string $statut = self::STATUT_EN_ATTENTE;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $montantTotal = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeItem::class, cascade: ['persist', 'remove'])]
    private Collection $commandeItems;

    #[ORM\OneToOne(mappedBy: 'commande', cascade: ['persist', 'remove'])]
    private ?Paiement $paiement = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?ZoneLivraison $zoneLivraison = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Livreur $livreur = null;

    public function __construct()
    {
        $this->commandeItems = new ArrayCollection();
        $this->dateCommande = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getTypeCommande(): ?string
    {
        return $this->typeCommande;
    }

    public function setTypeCommande(string $typeCommande): static
    {
        $this->typeCommande = $typeCommande;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): static
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): static
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    /**
     * @return Collection<int, CommandeItem>
     */
    public function getCommandeItems(): Collection
    {
        return $this->commandeItems;
    }

    public function addCommandeItem(CommandeItem $commandeItem): static
    {
        if (!$this->commandeItems->contains($commandeItem)) {
            $this->commandeItems->add($commandeItem);
            $commandeItem->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeItem(CommandeItem $commandeItem): static
    {
        if ($this->commandeItems->removeElement($commandeItem)) {
            // set the owning side to null (unless already changed)
            if ($commandeItem->getCommande() === $this) {
                $commandeItem->setCommande(null);
            }
        }

        return $this;
    }

    public function getPaiement(): ?Paiement
    {
        return $this->paiement;
    }

    public function setPaiement(?Paiement $paiement): static
    {
        // unset the owning side of the relation if necessary
        if ($paiement === null && $this->paiement !== null) {
            $this->paiement->setCommande(null);
        }

        // set the owning side of the relation if necessary
        if ($paiement !== null && $paiement->getCommande() !== $this) {
            $paiement->setCommande($this);
        }

        $this->paiement = $paiement;

        return $this;
    }

    public function getZoneLivraison(): ?ZoneLivraison
    {
        return $this->zoneLivraison;
    }

    public function setZoneLivraison(?ZoneLivraison $zoneLivraison): static
    {
        $this->zoneLivraison = $zoneLivraison;

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): static
    {
        $this->livreur = $livreur;

        return $this;
    }

    public function isPayee(): bool
    {
        return $this->paiement !== null;
    }

    public function calculerMontantTotal(): void
    {
        $total = 0;
        foreach ($this->commandeItems as $item) {
            $total += $item->getPrixUnitaire() * $item->getQuantite();
        }
        $this->montantTotal = $total;
    }
}
