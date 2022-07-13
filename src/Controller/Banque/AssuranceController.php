<?php

namespace App\Controller\Banque;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssuranceController extends AbstractController
{
    #[Route('/banque/assurance', name: 'app_banque_assurance')]
    public function index(): Response
    {
        return $this->render('banque/assurance/index.html.twig', [
            'controller_name' => 'AssuranceController',
        ]);
    }
}
