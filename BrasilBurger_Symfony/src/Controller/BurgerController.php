<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Form\BurgerType;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/burger')]
#[IsGranted('ROLE_GESTIONNAIRE')]
class BurgerController extends AbstractController
{
    #[Route('/', name: 'app_burger_index', methods: ['GET'])]
    public function index(BurgerRepository $burgerRepository): Response
    {
        return $this->render('burger/index.html.twig', [
            'burgers' => $burgerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_burger_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $burger = new Burger();
        $form = $this->createForm(BurgerType::class, $burger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($burger);
            $entityManager->flush();

            $this->addFlash('success', 'Le burger a été créé avec succès.');

            return $this->redirectToRoute('app_burger_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('burger/new.html.twig', [
            'burger' => $burger,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_burger_show', methods: ['GET'])]
    public function show(Burger $burger): Response
    {
        return $this->render('burger/show.html.twig', [
            'burger' => $burger,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_burger_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Burger $burger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BurgerType::class, $burger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le burger a été modifié avec succès.');

            return $this->redirectToRoute('app_burger_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('burger/edit.html.twig', [
            'burger' => $burger,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/archive', name: 'app_burger_archive', methods: ['POST'])]
    public function archive(Burger $burger, EntityManagerInterface $entityManager): Response
    {
        $burger->setArchive(true);
        $entityManager->flush();

        $this->addFlash('success', 'Le burger a été archivé avec succès.');

        return $this->redirectToRoute('app_burger_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/unarchive', name: 'app_burger_unarchive', methods: ['POST'])]
    public function unarchive(Burger $burger, EntityManagerInterface $entityManager): Response
    {
        $burger->setArchive(false);
        $entityManager->flush();

        $this->addFlash('success', 'Le burger a été désarchivé avec succès.');

        return $this->redirectToRoute('app_burger_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_burger_delete', methods: ['POST'])]
    public function delete(Request $request, Burger $burger, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$burger->getId(), $request->request->get('_token'))) {
            $entityManager->remove($burger);
            $entityManager->flush();

            $this->addFlash('success', 'Le burger a été supprimé avec succès.');
        }

        return $this->redirectToRoute('app_burger_index', [], Response::HTTP_SEE_OTHER);
    }
}
