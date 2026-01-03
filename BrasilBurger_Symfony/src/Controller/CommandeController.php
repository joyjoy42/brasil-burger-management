<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeFilterType;
use App\Entity\Livreur;
use App\Repository\CommandeRepository;
use App\Repository\LivreurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/commande')]
#[IsGranted('ROLE_GESTIONNAIRE')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_commande_index', methods: ['GET', 'POST'])]
    public function index(CommandeRepository $commandeRepository, Request $request): Response
    {
        $form = $this->createForm(CommandeFilterType::class);
        $form->handleRequest($request);

        $commandes = [];
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $commandes = $commandeRepository->findByFilters(
                $data['type'] ?? null,
                $data['date'] ?? null,
                $data['statut'] ?? null,
                $data['client'] ?? null,
                $data['burger'] ?? null,
                $data['menu'] ?? null
            );
        } else {
            $commandes = $commandeRepository->findBy([], ['dateCommande' => 'DESC']);
        }

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
            'filter_form' => $form,
        ]);
    }

    #[Route('/en-cours', name: 'app_commande_en_cours', methods: ['GET'])]
    public function enCours(CommandeRepository $commandeRepository): Response
    {
        $commandes = $commandeRepository->findCommandesEnCoursDuJour();
        
        return $this->render('commande/en_cours.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}/annuler', name: 'app_commande_annuler', methods: ['POST'])]
    public function annuler(Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($commande->getStatut() === Commande::STATUT_EN_ATTENTE || $commande->getStatut() === Commande::STATUT_VALIDE) {
            $commande->setStatut(Commande::STATUT_ANNULE);
            $entityManager->flush();

            $this->addFlash('success', 'La commande a été annulée avec succès.');
        } else {
            $this->addFlash('error', 'Impossible d\'annuler cette commande.');
        }

        return $this->redirectToRoute('app_commande_index');
    }

    #[Route('/{id}/terminer', name: 'app_commande_terminer', methods: ['POST'])]
    public function terminer(Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($commande->getStatut() === Commande::STATUT_PRETE) {
            $commande->setStatut(Commande::STATUT_TERMINE);
            $entityManager->flush();

            $this->addFlash('success', 'La commande a été terminée avec succès.');
        } else {
            $this->addFlash('error', 'Impossible de terminer cette commande.');
        }

        return $this->redirectToRoute('app_commande_index');
    }

    #[Route('/{id}/changer-statut', name: 'app_commande_changer_statut', methods: ['POST'])]
    public function changerStatut(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $nouveauStatut = $request->request->get('statut');
        
        if (in_array($nouveauStatut, [
            Commande::STATUT_EN_ATTENTE,
            Commande::STATUT_VALIDE,
            Commande::STATUT_PREPARATION,
            Commande::STATUT_PRETE,
            Commande::STATUT_TERMINE
        ])) {
            $commande->setStatut($nouveauStatut);
            $entityManager->flush();

            $this->addFlash('success', 'Le statut de la commande a été mis à jour avec succès.');
        } else {
            $this->addFlash('error', 'Statut invalide.');
        }

        return $this->redirectToRoute('app_commande_show', ['id' => $commande->getId()]);
    }
    #[Route('/{id}/affecter-livreur', name: 'app_commande_affecter_livreur', methods: ['POST'])]
    public function affecterLivreur(Request $request, Commande $commande, LivreurRepository $livreurRepository, EntityManagerInterface $entityManager): Response
    {
        $livreurId = $request->request->get('livreur_id');
        $livreur = $livreurRepository->find($livreurId);

        if ($livreur) {
            $commande->setLivreur($livreur);
            $commande->setStatut(Commande::STATUT_PRETE); // Or keeping current status? Usually assigned when ready.
            $entityManager->flush();

            $this->addFlash('success', 'Livreur affecté avec succès.');
        } else {
            $this->addFlash('error', 'Livreur non trouvé.');
        }

        return $this->redirectToRoute('app_commande_show', ['id' => $commande->getId()]);
    }
}
