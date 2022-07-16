<?php

namespace App\Controller\Banque;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmpruntController extends AbstractController
{
    #[Route('/credit/credit-immobilier', name: 'app_banque_emprunt_immobilier')]
    public function immobilier(): Response
    {
        return $this->render('banque/emprunt/immobilier.html.twig', [
            'controller_name' => 'EmpruntController',
        ]);
    }

    #[Route('/credit/credit-personnel', name: 'app_banque_emprunt_personnel')]
    public function personnel(): Response
    {
        return $this->render('banque/emprunt/personnel.html.twig', [
            'controller_name' => 'EmpruntController',
        ]);
    }

    #[Route('/credit/credit-auto', name: 'app_banque_emprunt_auto')]
    public function auto(): Response
    {
        return $this->render('banque/emprunt/auto.html.twig', [
            'controller_name' => 'EmpruntController',
        ]);
    }
}
