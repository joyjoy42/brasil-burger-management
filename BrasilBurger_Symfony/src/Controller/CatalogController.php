<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/catalog')]
class CatalogController extends AbstractController
{
    #[Route('', name: 'app_catalog_index', methods: ['GET'])]
    public function index(BurgerRepository $burgerRepo, \App\Repository\ComplementRepository $compRepo, \App\Repository\MenuRepository $menuRepo): Response
    {
        return $this->render('catalog/index.html.twig', [
            'burgers' => $burgerRepo->findAll(),
            'complements' => $compRepo->findAll(),
            'menus' => $menuRepo->findAll(),
        ]);
    }

    #[Route('/burger/new', name: 'app_catalog_burger_new', methods: ['GET', 'POST'])]
    public function newBurger(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $burger = new Burger();
            $burger->setName($request->request->get('name'));
            $burger->setPrice($request->request->get('price'));
            $burger->setDescription($request->request->get('description'));
            $em->persist($burger);
            $em->flush();
            $this->addFlash('success', 'Burger ajouté !');
            return $this->redirectToRoute('app_catalog_index');
        }
        return $this->render('catalog/burger_new.html.twig');
    }
}
