<?php

namespace App\Controller\Banque;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EpagneController extends AbstractController
{
    #[Route('/offres/epargne/livret-epargne', name: 'app_banque_epagne')]
    public function index(): Response
    {
        return $this->render('banque/epagne/index.html.twig', [
            'controller_name' => 'EpagneController',
        ]);
    }
}
