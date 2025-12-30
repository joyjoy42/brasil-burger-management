<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/orders')]
class OrderController extends AbstractController
{
    #[Route('', name: 'app_order_index')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $qb = $em->getRepository(Order::class)->createQueryBuilder('o');
        
        if ($status = $request->query->get('status')) {
            $qb->andWhere('o.etat = :status')->setParameter('status', $status);
        }
        if ($date = $request->query->get('date')) {
            $qb->andWhere('o.dateCommande LIKE :date')->setParameter('date', $date . '%');
        }
        
        $orders = $qb->orderBy('o.dateCommande', 'DESC')->getQuery()->getResult();
        
        return $this->render('order/index.html.twig', ['orders' => $orders]);
    }

    #[Route('/{id}', name: 'app_order_show')]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $order = $em->getRepository(Order::class)->find($id);
        return $this->render('order/show.html.twig', ['order' => $order]);
    }

    #[Route('/{id}/status', name: 'app_order_update_status', methods: ['POST'])]
    public function updateStatus(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $order = $em->getRepository(Order::class)->find($id);
        $newStatus = $request->request->get('status');
        
        if (in_array($newStatus, ['en_attente', 'valide', 'annule', 'termine'])) {
            $order->setEtat($newStatus);
            $em->flush();
            $this->addFlash('success', 'Statut mis à jour');
        }
        
        return $this->redirectToRoute('app_order_show', ['id' => $id]);
    }
}
