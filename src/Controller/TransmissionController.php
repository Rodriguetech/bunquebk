<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransmissionController extends AbstractController
{
    #[Route('/transmission/{transation}', name: 'transmission')]
    public function index($transation): Response
    {
        return $this->render('transmission/index.html.twig',[
            'idtransaction' => intval($transation),
        ]);
    }


    #[Route('/transmission/code/{transation}', name: 'transmission_code')]
    public function tr($transation): Response
    {
        return $this->render('transmission/tr.html.twig',[
            'idtransaction' => intval($transation),
        ]);
    }


    #[Route('/transmission/code/mess/{transation}', name: 'transmission_mess')]
    public function mess($transation): Response
    {
        return $this->render('transmission/mess.html.twig',[
            'idtransaction' => intval($transation),
        ]);
    }

}
