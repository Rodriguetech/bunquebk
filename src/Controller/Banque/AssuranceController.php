<?php

namespace App\Controller\Banque;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssuranceController extends AbstractController
{
    #[Route('/assurance-vie', name: 'app_banque_assurance_vie')]
    public function vie(): Response
    {
        return $this->render('banque/assurance/vie.html.twig', [
            'controller_name' => 'AssuranceController',
        ]);
    }

    #[Route('/assurance-habitation', name: 'app_banque_assurance_habitation')]
    public function habitat(): Response
    {
        return $this->render('banque/assurance/habitat.html.twig', [
            'controller_name' => 'AssuranceController',
        ]);
    }

}
