<?php

namespace App\Controller\Banque;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    #[Route('/banque/compte', name: 'app_banque_compte')]
    public function index(): Response
    {
        return $this->render('banque/compte/index.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }
}
