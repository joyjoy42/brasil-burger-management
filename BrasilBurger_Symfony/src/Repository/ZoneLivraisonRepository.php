<?php

namespace App\Repository;

use App\Entity\ZoneLivraison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ZoneLivraison>
 *
 * @method ZoneLivraison|null find($id, $lockMode = null, $lockVersion = null)
 * @method ZoneLivraison|null findOneBy(array $criteria, array $orderBy = null)
 * @method ZoneLivraison[]    findAll()
 * @method ZoneLivraison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZoneLivraisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZoneLivraison::class);
    }

    public function save(ZoneLivraison $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ZoneLivraison $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
