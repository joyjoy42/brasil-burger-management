<?php

namespace App\Controller;

use App\Entity\MenuItem;
use App\Entity\Menu;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Product;
use App\Form\ProductType;
use App\Form\MenuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

#[Route('/manager')]
class ManagerController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/stats', name: 'manager_stats')]
    public function stats(): Response
    {
        $today = new \DateTime('today');
        
        $orders = $this->entityManager->getRepository(Order::class);
        
        // Commandes en cours de la journée
        $pendingToday = $orders->createQueryBuilder('o')
            ->select('count(o.id)')
            ->where('o.dateCommande >= :today')
            ->andWhere('o.etat != :delivered')
            ->andWhere('o.etat != :cancelled')
            ->setParameter('today', $today)
            ->setParameter('delivered', 'DELIVERED')
            ->setParameter('cancelled', 'CANCELLED')
            ->getQuery()
            ->getSingleScalarResult();

        // Commandes validées de la journée
        $validatedToday = $orders->createQueryBuilder('o')
            ->select('count(o.id)')
            ->where('o.dateCommande >= :today')
            ->andWhere('o.etat = :paid OR o.etat = :ready OR o.etat = :finished OR o.etat = :delivered')
            ->setParameter('today', $today)
            ->setParameter('paid', 'PAID')
            ->setParameter('ready', 'READY')
            ->setParameter('finished', 'FINISHED')
            ->setParameter('delivered', 'DELIVERED')
            ->getQuery()
            ->getSingleScalarResult();

        // Commandes annulées de la journée
        $cancelledToday = $orders->createQueryBuilder('o')
            ->select('count(o.id)')
            ->where('o.dateCommande >= :today')
            ->andWhere('o.etat = :cancelled')
            ->setParameter('today', $today)
            ->setParameter('cancelled', 'CANCELLED')
            ->getQuery()
            ->getSingleScalarResult();

        // Recettes journalières
        $revenueToday = $orders->createQueryBuilder('o')
            ->select('sum(o.prixTotal)')
            ->where('o.dateCommande >= :today')
            ->andWhere('o.etat != :cancelled') // Count all non-cancelled orders revenue
            ->setParameter('today', $today)
            ->setParameter('cancelled', 'CANCELLED')
            ->getQuery()
            ->getSingleScalarResult() ?? 0;

        // Revenue weekly trend for dashboard chart
        $weeklyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = new \DateTime('-'.$i.' days');
            $start = clone $date; $start->setTime(0, 0, 0);
            $end = clone $date; $end->setTime(23, 59, 59);
            
            $rev = $orders->createQueryBuilder('o')
                ->select('sum(o.prixTotal)')
                ->where('o.dateCommande >= :start AND o.dateCommande <= :end')
                ->andWhere('o.etat != :cancelled')
                ->setParameter('start', $start)
                ->setParameter('end', $end)
                ->setParameter('cancelled', 'CANCELLED')
                ->getQuery()
                ->getSingleScalarResult() ?? 0;
                
            $weeklyRevenue[] = [
                'day' => $date->format('D'),
                'revenue' => (float)$rev
            ];
        }

        // Burgers les plus vendus
        $topBurgers = $this->entityManager->getRepository(OrderDetail::class)
            ->createQueryBuilder('od')
            ->select('p.nom, sum(od.quantite) as total, sum(od.quantite * od.prixUnitaire) as revenue')
            ->join('od.product', 'p')
            ->where('p.type = :type')
            ->setParameter('type', 'BURGER')
            ->groupBy('p.id')
            ->orderBy('total', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        return $this->render('manager/stats.html.twig', [
            'pendingToday' => $pendingToday,
            'validatedToday' => $validatedToday,
            'revenueToday' => $revenueToday,
            'cancelledToday' => $cancelledToday,
            'topBurgers' => $topBurgers,
            'weeklyRevenue' => $weeklyRevenue,
        ]);
    }

    #[Route('/orders', name: 'manager_orders')]
    public function orders(\Symfony\Component\HttpFoundation\Request $request): Response
    {
        $search = $request->query->get('search');
        $type = $request->query->get('type');
        $status = $request->query->get('status');
        $date = $request->query->get('date');

        $queryBuilder = $this->entityManager->getRepository(Order::class)->createQueryBuilder('o')
            ->leftJoin('o.client', 'c')
            ->orderBy('o.dateCommande', 'DESC');

        if ($search) {
            $queryBuilder->andWhere('c.nom LIKE :search OR c.prenom LIKE :search OR o.id = :searchId')
                ->setParameter('search', '%'.$search.'%')
                ->setParameter('searchId', is_numeric($search) ? (int)$search : -1);
        }

        if ($type && $type !== 'all') {
            $queryBuilder->andWhere('o.typeCommande = :type')
                ->setParameter('type', $type);
        }

        if ($status && $status !== 'all') {
            $queryBuilder->andWhere('o.etat = :status')
                ->setParameter('status', $status);
        }

        if ($date) {
            $queryBuilder->andWhere('o.dateCommande >= :dateStart AND o.dateCommande <= :dateEnd')
                ->setParameter('dateStart', new \DateTime($date.' 00:00:00'))
                ->setParameter('dateEnd', new \DateTime($date.' 23:59:59'));
        }

        $orders = $queryBuilder->getQuery()->getResult();

        return $this->render('manager/orders.html.twig', [
            'orders' => $orders,
            'filters' => [
                'search' => $search,
                'type' => $type,
                'status' => $status,
                'date' => $date,
            ]
        ]);
    }

    #[Route('/products', name: 'manager_products')]
    public function products(\Symfony\Component\HttpFoundation\Request $request): Response
    {
        $search = $request->query->get('search');
        $type = $request->query->get('type');

        $queryBuilder = $this->entityManager->getRepository(Product::class)->createQueryBuilder('p')
            ->where('p.estArchive = false')
            ->orderBy('p.nom', 'ASC');

        if ($search) {
            $queryBuilder->andWhere('p.nom LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }

        if ($type && $type !== 'all' && $type !== 'MENU') {
            $queryBuilder->andWhere('p.type = :type')
                ->setParameter('type', $type);
        }

        $products = [];
        if (!$type || $type === 'all' || $type === 'BURGER' || $type === 'COMPLEMENT') {
            $products = $queryBuilder->getQuery()->getResult();
        }

        // Also fetch menus
        $menusQueryBuilder = $this->entityManager->getRepository(Menu::class)->createQueryBuilder('m')
            ->where('m.estArchive = false')
            ->orderBy('m.nom', 'ASC');
            
        if ($search) {
            $menusQueryBuilder->andWhere('m.nom LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }
        
        $menus = [];
        if (!$type || $type === 'all' || $type === 'MENU') {
            $menus = $menusQueryBuilder->getQuery()->getResult();
        }

        return $this->render('manager/products.html.twig', [
            'products' => $products,
            'menus' => $menus,
            'filters' => [
                'search' => $search,
                'type' => $type,
            ]
        ]);
    }

    #[Route('/products/new', name: 'manager_product_new')]
    public function productNew(Request $request, SluggerInterface $slugger): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = $this->uploadImage($imageFile, $slugger);
                $product->setImage($newFilename);
            }

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->redirectToRoute('manager_products');
        }

        return $this->render('manager/product_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter un produit',
            'product' => $product
        ]);
    }

    #[Route('/products/{id}/edit', name: 'manager_product_edit')]
    public function productEdit(int $id, Request $request, SluggerInterface $slugger): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);
        if (!$product) throw $this->createNotFoundException('Produit non trouvé');

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = $this->uploadImage($imageFile, $slugger);
                $product->setImage($newFilename);
            }

            $this->entityManager->flush();
            return $this->redirectToRoute('manager_products');
        }

        return $this->render('manager/product_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier le produit',
            'product' => $product
        ]);
    }

    #[Route('/products/{id}/delete', name: 'manager_product_delete')]
    public function productDelete(int $id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);
        if ($product) {
            $product->setEstArchive(true);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('manager_products');
    }

    #[Route('/menus/new', name: 'manager_menu_new')]
    public function menuNew(Request $request, SluggerInterface $slugger): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = $this->uploadImage($imageFile, $slugger);
                $menu->setImage($newFilename);
            }

            $burger = $form->get('burger')->getData();
            if ($burger) {
                $menuItem = new MenuItem();
                $menuItem->setMenu($menu);
                $menuItem->setProduct($burger);
                $menuItem->setQuantite(1);
                $menu->addMenuItem($menuItem);
            }

            $complements = $form->get('complements')->getData();
            foreach ($complements as $complement) {
                $menuItem = new MenuItem();
                $menuItem->setMenu($menu);
                $menuItem->setProduct($complement);
                $menuItem->setQuantite(1);
                $menu->addMenuItem($menuItem);
            }

            $this->entityManager->persist($menu);
            $this->entityManager->flush();

            return $this->redirectToRoute('manager_products');
        }

        return $this->render('manager/menu_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Créer un menu',
            'menu' => $menu
        ]);
    }

    private function uploadImage($imageFile, SluggerInterface $slugger): string
    {
        Configuration::instance($_ENV['CLOUDINARY_URL']);
        $upload = new UploadApi();
        
        try {
            $result = $upload->upload($imageFile->getRealPath(), [
                'folder' => 'brasil-burger',
                'use_filename' => true,
                'unique_filename' => true,
            ]);
            
            return $result['secure_url'];
        } catch (\Exception $e) {
            // Log or handle error
            return '';
        }
    }

    #[Route('/deliveries', name: 'manager_deliveries')]
    public function deliveries(): Response
    {
        $orderRepo = $this->entityManager->getRepository(Order::class);
        $zoneRepo = $this->entityManager->getRepository(Zone::class);
        $userRepo = $this->entityManager->getRepository(User::class);

        // Stats
        $inProgress = $orderRepo->count(['etat' => 'READY']); // Orders ready but not yet delivered
        $delivered = $orderRepo->count(['etat' => 'DELIVERED']);
        $zoneCount = $zoneRepo->count([]);
        $livreurCount = $userRepo->count(['role' => 'LIVREUR']);

        // Zones with active deliveries
        $zones = $zoneRepo->findAll();
        $zoneStats = [];
        foreach ($zones as $zone) {
            $activeCount = $orderRepo->count(['zone' => $zone, 'etat' => 'READY']);
            $zoneStats[] = [
                'zone' => $zone,
                'activeCount' => $activeCount,
                'orders' => $orderRepo->findBy(['zone' => $zone, 'etat' => 'READY'], ['dateCommande' => 'ASC'], 3)
            ];
        }

        // Livreurs
        $livreurs = $userRepo->findBy(['role' => 'LIVREUR']);
        $livreurStats = [];
        foreach ($livreurs as $livreur) {
            $currentDelivery = $orderRepo->findOneBy(['livreur' => $livreur, 'etat' => 'READY']);
            $livreurStats[] = [
                'livreur' => $livreur,
                'totalDeliveries' => $orderRepo->count(['livreur' => $livreur]),
                'currentDelivery' => $currentDelivery
            ];
        }

        return $this->render('manager/deliveries.html.twig', [
            'inProgress' => $inProgress,
            'delivered' => $delivered,
            'zoneCount' => $zoneCount,
            'livreurCount' => $livreurCount,
            'zoneStats' => $zoneStats,
            'livreurStats' => $livreurStats,
        ]);
    }

    #[Route('/history', name: 'manager_history')]
    public function history(): Response
    {
        $orderRepo = $this->entityManager->getRepository(Order::class);
        
        // Weekly Revenue (last 7 days)
        $weeklyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = new \DateTime('-'.$i.' days');
            $start = clone $date; $start->setTime(0, 0, 0);
            $end = clone $date; $end->setTime(23, 59, 59);
            
            $rev = $orderRepo->createQueryBuilder('o')
                ->select('sum(o.prixTotal)')
                ->where('o.dateCommande >= :start AND o.dateCommande <= :end')
                ->andWhere('o.etat != :cancelled')
                ->setParameter('start', $start)
                ->setParameter('end', $end)
                ->setParameter('cancelled', 'CANCELLED')
                ->getQuery()
                ->getSingleScalarResult() ?? 0;
                
            $weeklyRevenue[] = [
                'day' => $date->format('D'),
                'revenue' => $rev
            ];
        }

        // Monthly Revenue (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = new \DateTime('first day of -'.$i.' month');
            $start = clone $date; $start->setTime(0, 0, 0);
            $end = clone $date; $end->modify('last day of this month')->setTime(23, 59, 59);
            
            $rev = $orderRepo->createQueryBuilder('o')
                ->select('sum(o.prixTotal)')
                ->where('o.dateCommande >= :start AND o.dateCommande <= :end')
                ->andWhere('o.etat != :cancelled')
                ->setParameter('start', $start)
                ->setParameter('end', $end)
                ->setParameter('cancelled', 'CANCELLED')
                ->getQuery()
                ->getSingleScalarResult() ?? 0;
                
            $monthlyRevenue[] = [
                'month' => $date->format('M'),
                'revenue' => $rev
            ];
        }

        return $this->render('manager/history.html.twig', [
            'weeklyRevenue' => $weeklyRevenue,
            'monthlyRevenue' => $monthlyRevenue,
        ]);
    }
}
