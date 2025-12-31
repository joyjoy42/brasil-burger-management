<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function save(Commande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Commande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findCommandesDuJour(): array
    {
        return $this->createQueryBuilder('c')
            ->where('DATE(c.dateCommande) = CURRENT_DATE()')
            ->orderBy('c.dateCommande', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findCommandesEnCoursDuJour(): array
    {
        return $this->createQueryBuilder('c')
            ->where('DATE(c.dateCommande) = CURRENT_DATE()')
            ->andWhere('c.statut IN (:statuts)')
            ->setParameter('statuts', ['en_attente', 'valide', 'preparation', 'prete'])
            ->orderBy('c.dateCommande', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findCommandesValideesDuJour(): array
    {
        return $this->createQueryBuilder('c')
            ->where('DATE(c.dateCommande) = CURRENT_DATE()')
            ->andWhere('c.statut = :statut')
            ->setParameter('statut', 'valide')
            ->orderBy('c.dateCommande', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findCommandesAnnuleesDuJour(): array
    {
        return $this->createQueryBuilder('c')
            ->where('DATE(c.dateCommande) = CURRENT_DATE()')
            ->andWhere('c.statut = :statut')
            ->setParameter('statut', 'annule')
            ->orderBy('c.dateCommande', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findRecettesJournalieres(): float
    {
        return $this->createQueryBuilder('c')
            ->select('SUM(c.montantTotal)')
            ->where('DATE(c.dateCommande) = CURRENT_DATE()')
            ->andWhere('c.statut IN (:statuts)')
            ->setParameter('statuts', ['valide', 'preparation', 'prete', 'termine'])
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }

    public function findByFilters(?string $type = null, ?\DateTimeInterface $date = null, ?string $statut = null, ?int $clientId = null): array
    {
        $qb = $this->createQueryBuilder('c');

        if ($type) {
            $qb->andWhere('c.typeCommande = :type')
               ->setParameter('type', $type);
        }

        if ($date) {
            $qb->andWhere('DATE(c.dateCommande) = DATE(:date)')
               ->setParameter('date', $date);
        }

        if ($statut) {
            $qb->andWhere('c.statut = :statut')
               ->setParameter('statut', $statut);
        }

        if ($clientId) {
            $qb->andWhere('c.client = :client')
               ->setParameter('client', $clientId);
        }

        return $qb->orderBy('c.dateCommande', 'DESC')
                  ->getQuery()
                  ->getResult();
    }
}
