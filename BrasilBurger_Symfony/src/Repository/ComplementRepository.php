<?php

namespace App\Repository;

use App\Entity\Complement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Complement>
 *
 * @method Complement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Complement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Complement[]    findAll()
 * @method Complement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComplementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Complement::class);
    }

    public function save(Complement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Complement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findNonArchives(): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.archive = :archive')
            ->setParameter('archive', false)
            ->orderBy('c.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
