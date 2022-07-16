<?php

namespace App\Controller\Banque;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    #[Route('/offres/compte-et-cartes/compte-courant', name: 'app_banque_compte_courant')]
    public function compteCourant(): Response
    {
        return $this->render('banque/compte/courant.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }

    #[Route('/offres/compte-et-cartes/compte-joint', name: 'app_banque_compte_joint')]
    public function compteJoint(): Response
    {
        return $this->render('banque/compte/joint.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }

    #[Route('/cartes-bancaires', name: 'app_banque_compte_bancaire')]
    public function compteBancaire(): Response
    {
        return $this->render('banque/compte/bancaire.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }
}
