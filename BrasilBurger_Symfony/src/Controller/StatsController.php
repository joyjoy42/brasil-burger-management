<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Repository\OrderItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/stats')]
class StatsController extends AbstractController
{
    #[Route('', name: 'app_stats_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository, OrderItemRepository $itemRepository): Response
    {
        $today = new \DateTime('today');
        $tomorrow = new \DateTime('tomorrow');

        // Required daily statistics from cahier de charge
        // 1. Commandes en cours de la journée
        $ordersInProgress = $orderRepository->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->where('o.createdAt >= :today')
            ->andWhere('o.createdAt < :tomorrow')
            ->andWhere('o.status IN (:statuses)')
            ->setParameter('today', $today)
            ->setParameter('tomorrow', $tomorrow)
            ->setParameter('statuses', ['en_attente', 'valide'])
            ->getQuery()
            ->getSingleScalarResult();

        // 2. Commandes validées de la journée
        $validatedOrders = $orderRepository->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->where('o.createdAt >= :today')
            ->andWhere('o.createdAt < :tomorrow')
            ->andWhere('o.status = :status')
            ->setParameter('today', $today)
            ->setParameter('tomorrow', $tomorrow)
            ->setParameter('status', 'valide')
            ->getQuery()
            ->getSingleScalarResult();

        // 3. Recettes journalières
        $dailyRevenue = $orderRepository->createQueryBuilder('o')
            ->select('SUM(o.totalAmount)')
            ->where('o.createdAt >= :today')
            ->andWhere('o.createdAt < :tomorrow')
            ->andWhere('o.status != :cancelled')
            ->setParameter('today', $today)
            ->setParameter('tomorrow', $tomorrow)
            ->setParameter('cancelled', 'annule')
            ->getQuery()
            ->getSingleScalarResult() ?? 0;

        // 4. Burgers au menu les plus vendus de la journée
        $topBurgersToday = $itemRepository->createQueryBuilder('it')
            ->select('b.name as name, SUM(it.quantity) as total')
            ->join('it.order', 'o')
            ->join('it.burger', 'b')
            ->where('o.createdAt >= :today')
            ->andWhere('o.createdAt < :tomorrow')
            ->andWhere('o.status != :cancelled')
            ->groupBy('b.id')
            ->orderBy('total', 'DESC')
            ->setParameter('today', $today)
            ->setParameter('tomorrow', $tomorrow)
            ->setParameter('cancelled', 'annule')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        // 5. Commandes annulées du jour
        $cancelledOrders = $orderRepository->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->where('o.createdAt >= :today')
            ->andWhere('o.createdAt < :tomorrow')
            ->andWhere('o.status = :status')
            ->setParameter('today', $today)
            ->setParameter('tomorrow', $tomorrow)
            ->setParameter('status', 'annule')
            ->getQuery()
            ->getSingleScalarResult();

        // Weekly Revenue for chart
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = new \DateTime("-$i days");
            $dayName = $date->format('D');
            $revenue = $orderRepository->createQueryBuilder('o')
                ->select('SUM(o.totalAmount)')
                ->where('o.createdAt >= :start')
                ->andWhere('o.createdAt < :end')
                ->andWhere('o.status != :annule')
                ->setParameter('start', $date->format('Y-m-d 00:00:00'))
                ->setParameter('end', $date->format('Y-m-d 23:59:59'))
                ->setParameter('annule', 'annule')
                ->getQuery()
                ->getSingleScalarResult() ?? 0;
            
            $last7Days[] = ['label' => $dayName, 'value' => $revenue];
        }

        return $this->render('stats/index.html.twig', [
            'orders_in_progress' => $ordersInProgress,
            'validated_orders' => $validatedOrders,
            'daily_revenue' => $dailyRevenue,
            'top_burgers_today' => $topBurgersToday,
            'cancelled_orders' => $cancelledOrders,
            'weekly_revenue' => $last7Days,
        ]);
    }
}
