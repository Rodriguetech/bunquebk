<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartesController extends AbstractController
{
    #[Route('/cartes-bancaires', name: 'app_cartes')]
    public function index(): Response
    {
        return $this->render('cartes/index.html.twig', [
            'controller_name' => 'CartesController',
        ]);
    }
}
