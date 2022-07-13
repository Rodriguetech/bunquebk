<?php

namespace App\Controller\Banque;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmpruntController extends AbstractController
{
    #[Route('/banque/emprunt', name: 'app_banque_emprunt')]
    public function index(): Response
    {
        return $this->render('banque/emprunt/index.html.twig', [
            'controller_name' => 'EmpruntController',
        ]);
    }
}
