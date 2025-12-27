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
        // 1. Weekly Revenue
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

        // 2. Top Selling Burgers (Top 3)
        $topBurgers = $itemRepository->createQueryBuilder('it')
            ->select('b.name as name, SUM(it.quantity) as total')
            ->join('it.burger', 'b')
            ->groupBy('b.id')
            ->orderBy('total', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();

        // 3. Status Distribution
        $statusDistribution = $orderRepository->createQueryBuilder('o')
            ->select('o.status, COUNT(o.id) as total')
            ->groupBy('o.status')
            ->getQuery()
            ->getResult();

        return $this->render('stats/index.html.twig', [
            'weekly_revenue' => $last7Days,
            'top_burgers' => $topBurgers,
            'status_distribution' => $statusDistribution,
        ]);
    }
}
