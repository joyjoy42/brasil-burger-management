<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/stats')]
class StatsController extends AbstractController
{
    #[Route('', name: 'app_stats_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $today = new \DateTime('today');
        $tomorrow = new \DateTime('tomorrow');
        $repo = $em->getRepository(Order::class);
        
        // Commandes en cours
        $ordersInProgress = $repo->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->where('o.dateCommande >= :today')
            ->andWhere('o.dateCommande < :tomorrow')
            ->andWhere('o.etat IN (:statuses)')
            ->setParameter('today', $today)
            ->setParameter('tomorrow', $tomorrow)
            ->setParameter('statuses', ['en_attente', 'valide'])
            ->getQuery()->getSingleScalarResult();
        
        // Commandes validées
        $validatedOrders = $repo->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->where('o.dateCommande >= :today')
            ->andWhere('o.dateCommande < :tomorrow')
            ->andWhere('o.etat = :status')
            ->setParameter('today', $today)
            ->setParameter('tomorrow', $tomorrow)
            ->setParameter('status', 'valide')
            ->getQuery()->getSingleScalarResult();
        
        // Recettes journalières
        $dailyRevenue = $repo->createQueryBuilder('o')
            ->select('SUM(o.montantTotal)')
            ->where('o.dateCommande >= :today')
            ->andWhere('o.dateCommande < :tomorrow')
            ->andWhere('o.etat != :cancelled')
            ->setParameter('today', $today)
            ->setParameter('tomorrow', $tomorrow)
            ->setParameter('cancelled', 'annule')
            ->getQuery()->getSingleScalarResult() ?? 0;
        
        // Commandes annulées
        $cancelledOrders = $repo->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->where('o.dateCommande >= :today')
            ->andWhere('o.dateCommande < :tomorrow')
            ->andWhere('o.etat = :status')
            ->setParameter('today', $today)
            ->setParameter('tomorrow', $tomorrow)
            ->setParameter('status', 'annule')
            ->getQuery()->getSingleScalarResult();
        
        return $this->render('stats/index.html.twig', [
            'orders_in_progress' => $ordersInProgress,
            'validated_orders' => $validatedOrders,
            'daily_revenue' => $dailyRevenue,
            'cancelled_orders' => $cancelledOrders,
        ]);
    }
}
