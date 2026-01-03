<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/healthz', name: 'app_health_check', methods: ['GET'])]
    public function index(): Response
    {
        return new Response('OK');
    }
}
