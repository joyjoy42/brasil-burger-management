<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/orders')]
class OrderController extends AbstractController
{
    #[Route('', name: 'app_order_index', methods: ['GET'])]
    public function index(Request $request, OrderRepository $orderRepository): Response
    {
        $status = $request->query->get('status');
        $date = $request->query->get('date');
        $client = $request->query->get('client');
        $product = $request->query->get('product'); // burger or menu name

        $queryBuilder = $orderRepository->createQueryBuilder('o')
            ->leftJoin('o.user', 'u')
            ->leftJoin('o.orderItems', 'oi')
            ->leftJoin('oi.burger', 'b')
            ->leftJoin('oi.menu', 'm')
            ->orderBy('o.createdAt', 'DESC');

        if ($status) {
            $queryBuilder->andWhere('o.status = :status')
                ->setParameter('status', $status);
        }

        if ($date) {
            $queryBuilder->andWhere('o.createdAt LIKE :date')
                ->setParameter('date', $date . '%');
        }

        if ($client) {
            $queryBuilder->andWhere('u.nom LIKE :client OR u.prenom LIKE :client')
                ->setParameter('client', '%' . $client . '%');
        }

        if ($product) {
            $queryBuilder->andWhere('b.nom LIKE :product OR m.nom LIKE :product')
                ->setParameter('product', '%' . $product . '%');
        }

        $orders = $queryBuilder->getQuery()->getResult();

        return $this->render('order/index.html.twig', [
            'orders' => $orders,
            'current_status' => $status,
            'current_date' => $date,
            'current_client' => $client,
            'current_product' => $product,
        ]);
    }

    #[Route('/{id}', name: 'app_order_show', methods: ['GET'])]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}/status', name: 'app_order_update_status', methods: ['POST'])]
    public function updateStatus(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $newStatus = $request->request->get('status');
        $validStatuses = ['en_attente', 'valide', 'annule', 'termine'];

        if (in_array($newStatus, $validStatuses)) {
            $order->setStatus($newStatus);
            $order->setUpdatedAt(new \DateTime());
            $entityManager->flush();

            $this->addFlash('success', 'Statut de la commande mis à jour avec succès.');
        } else {
            $this->addFlash('error', 'Statut invalide.');
        }

        return $this->redirectToRoute('app_order_show', ['id' => $order->getId()]);
    }
}
