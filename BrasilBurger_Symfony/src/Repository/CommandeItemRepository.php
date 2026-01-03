<?php

namespace App\Repository;

use App\Entity\CommandeItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommandeItem>
 *
 * @method CommandeItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeItem[]    findAll()
 * @method CommandeItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeItem::class);
    }

    public function save(CommandeItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CommandeItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBurgersLesPlusVendusDuJour(): array
    {
        $start = new \DateTime('today midnight');
        $end = new \DateTime('tomorrow midnight');

        return $this->createQueryBuilder('ci')
            ->select('b.nom, SUM(ci.quantite) as totalVentes')
            ->innerJoin('ci.burger', 'b')
            ->innerJoin('ci.commande', 'c')
            ->where('c.dateCommande >= :start AND c.dateCommande < :end')
            ->andWhere('c.statut IN (:statuts)')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('statuts', ['valide', 'preparation', 'prete', 'termine'])
            ->groupBy('b.id', 'b.nom')
            ->orderBy('totalVentes', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findMenusLesPlusVendusDuJour(): array
    {
        $start = new \DateTime('today midnight');
        $end = new \DateTime('tomorrow midnight');

        return $this->createQueryBuilder('ci')
            ->select('m.nom, SUM(ci.quantite) as totalVentes')
            ->innerJoin('ci.menu', 'm')
            ->innerJoin('ci.commande', 'c')
            ->where('c.dateCommande >= :start AND c.dateCommande < :end')
            ->andWhere('c.statut IN (:statuts)')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('statuts', ['valide', 'preparation', 'prete', 'termine'])
            ->groupBy('m.id', 'm.nom')
            ->orderBy('totalVentes', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
