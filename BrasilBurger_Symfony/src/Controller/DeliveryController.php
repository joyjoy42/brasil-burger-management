<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Repository\ZoneRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/delivery')]
class DeliveryController extends AbstractController
{
    #[Route('', name: 'app_delivery_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository, ZoneRepository $zoneRepository, UserRepository $userRepository): Response
    {
        $ordersReady = $orderRepository->findBy([
            'status' => 'valide',
            'type' => 'livraison'
        ]);

        $zones = $zoneRepository->findAll();
        
        // Find users who have the 'livreur' role
        $livreurs = $userRepository->createQueryBuilder('u')
            ->join('u.role', 'r')
            ->where('r.name = :roleName')
            ->setParameter('roleName', 'livreur')
            ->getQuery()
            ->getResult();

        return $this->render('delivery/index.html.twig', [
            'orders' => $ordersReady,
            'zones' => $zones,
            'livreurs' => $livreurs,
        ]);
    }

    #[Route('/assign/{id}', name: 'app_delivery_assign', methods: ['POST'])]
    public function assign(Request $request, \App\Entity\Order $order, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $livreurId = $request->request->get('livreur_id');
        $livreur = $userRepository->find($livreurId);

        if ($livreur) {
            $assignment = new \App\Entity\DeliveryAssignment();
            $assignment->setOrder($order);
            $assignment->setLivreur($livreur);
            $entityManager->persist($assignment);
            
            $order->setStatus('en_cours'); // Or a specific status for delivery
            $entityManager->flush();

            $this->addFlash('success', 'Commande assignée au livreur.');
        }

        return $this->redirectToRoute('app_delivery_index');
    }
}
