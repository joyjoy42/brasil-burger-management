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
        $start = new \DateTime('today midnight');
        $end = new \DateTime('tomorrow midnight');

        return $this->createQueryBuilder('c')
            ->where('c.dateCommande >= :start AND c.dateCommande < :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->orderBy('c.dateCommande', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findCommandesEnCoursDuJour(): array
    {
        $start = new \DateTime('today midnight');
        $end = new \DateTime('tomorrow midnight');

        return $this->createQueryBuilder('c')
            ->where('c.dateCommande >= :start AND c.dateCommande < :end')
            ->andWhere('c.statut IN (:statuts)')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('statuts', ['en_attente', 'valide', 'preparation', 'prete'])
            ->orderBy('c.dateCommande', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findCommandesValideesDuJour(): array
    {
        $start = new \DateTime('today midnight');
        $end = new \DateTime('tomorrow midnight');

        return $this->createQueryBuilder('c')
            ->where('c.dateCommande >= :start AND c.dateCommande < :end')
            ->andWhere('c.statut = :statut')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('statut', 'valide')
            ->orderBy('c.dateCommande', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findCommandesAnnuleesDuJour(): array
    {
        $start = new \DateTime('today midnight');
        $end = new \DateTime('tomorrow midnight');

        return $this->createQueryBuilder('c')
            ->where('c.dateCommande >= :start AND c.dateCommande < :end')
            ->andWhere('c.statut = :statut')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('statut', 'annule')
            ->orderBy('c.dateCommande', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findRecettesJournalieres(): float
    {
        $start = new \DateTime('today midnight');
        $end = new \DateTime('tomorrow midnight');

        return $this->createQueryBuilder('c')
            ->select('SUM(c.montantTotal)')
            ->where('c.dateCommande >= :start AND c.dateCommande < :end')
            ->andWhere('c.statut IN (:statuts)')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('statuts', ['valide', 'preparation', 'prete', 'termine'])
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }

    public function findByFilters(?string $type = null, ?\DateTimeInterface $date = null, ?string $statut = null, ?int $clientId = null, ?int $burgerId = null, ?int $menuId = null): array
    {
        $qb = $this->createQueryBuilder('c');

        if ($type) {
            $qb->andWhere('c.typeCommande = :type')
               ->setParameter('type', $type);
        }

        if ($date) {
            $start = \DateTime::createFromInterface($date);
            $start->setTime(0, 0, 0);
            $end = clone $start;
            $end->modify('+1 day');

            $qb->andWhere('c.dateCommande >= :start AND c.dateCommande < :end')
               ->setParameter('start', $start)
               ->setParameter('end', $end);
        }

        if ($statut) {
            $qb->andWhere('c.statut = :statut')
               ->setParameter('statut', $statut);
        }

        if ($clientId) {
            $qb->andWhere('c.client = :client')
               ->setParameter('client', $clientId);
        }

        if ($burgerId) {
            $qb->innerJoin('c.commandeItems', 'cib')
               ->andWhere('cib.burger = :burger')
               ->setParameter('burger', $burgerId);
        }

        if ($menuId) {
            $qb->innerJoin('c.commandeItems', 'cim')
               ->andWhere('cim.menu = :menu')
               ->setParameter('menu', $menuId);
        }

        return $qb->orderBy('c.dateCommande', 'DESC')
                  ->getQuery()
                  ->getResult();
    }
}
