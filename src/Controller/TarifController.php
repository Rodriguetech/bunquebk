<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TarifController extends AbstractController
{
    #[Route('/tarifs', name: 'app_tarif')]
    public function index(): Response
    {
        return $this->render('tarif/index.html.twig', [
            'controller_name' => 'TarifController',
        ]);
    }
}
