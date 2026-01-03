<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\CommandeItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_GESTIONNAIRE')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(CommandeRepository $commandeRepository, CommandeItemRepository $commandeItemRepository): Response
    {
        // Statistiques du jour
        $commandesDuJour = $commandeRepository->findCommandesDuJour();
        $commandesEnCoursDuJour = $commandeRepository->findCommandesEnCoursDuJour();
        $commandesValideesDuJour = $commandeRepository->findCommandesValideesDuJour();
        $commandesAnnuleesDuJour = $commandeRepository->findCommandesAnnuleesDuJour();
        $recettesJournalieres = $commandeRepository->findRecettesJournalieres();
        $burgersPlusVendus = $commandeItemRepository->findBurgersLesPlusVendusDuJour();
        $menusPlusVendus = $commandeItemRepository->findMenusLesPlusVendusDuJour();

        return $this->render('dashboard/index.html.twig', [
            'commandes_du_jour' => count($commandesDuJour),
            'commandes_en_cours_du_jour' => count($commandesEnCoursDuJour),
            'commandes_validees_du_jour' => count($commandesValideesDuJour),
            'commandes_annulees_du_jour' => count($commandesAnnuleesDuJour),
            'recettes_journalieres' => $recettesJournalieres,
            'burgers_plus_vendus' => $burgersPlusVendus,
            'menus_plus_vendus' => $menusPlusVendus,
            'dernieres_commandes' => array_slice($commandesDuJour, 0, 5)
        ]);
    }
}
