<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(\App\Repository\OrderRepository $orderRepository): Response
    {
        $today = new \DateTime('today');
        
        $ordersToday = $orderRepository->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->where('o.createdAt >= :today')
            ->setParameter('today', $today)
            ->getQuery()
            ->getSingleScalarResult();

        $revenueToday = $orderRepository->createQueryBuilder('o')
            ->select('SUM(o.totalAmount)')
            ->where('o.createdAt >= :today')
            ->andWhere('o.status != :annule')
            ->setParameter('today', $today)
            ->setParameter('annule', 'annule')
            ->getQuery()
            ->getSingleScalarResult() ?? 0;

        $canceledToday = $orderRepository->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->where('o.createdAt >= :today')
            ->andWhere('o.status = :annule')
            ->setParameter('today', $today)
            ->setParameter('annule', 'annule')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('dashboard/index.html.twig', [
            'orders_today' => $ordersToday,
            'revenue_today' => $revenueToday,
            'canceled_today' => $canceledToday,
        ]);
    }
}
