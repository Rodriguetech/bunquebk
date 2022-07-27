<?php

namespace App\Controller;

use App\Controller\Admin\ScenarioCrudController;
use App\Entity\Code;
use App\Entity\Hackcompte;
use App\Entity\Transaction;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\CodeType;
use App\Form\HackcompteType;
use App\Form\TransactionType;
use App\Repository\DetailScenarioRepository;
use App\Repository\ScenarioRepository;
use App\Repository\TransactionRepository;
use App\services\ManageApiServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager ) {
        $this->entityManager = $entityManager;
    }


    #[Route('/account', name: 'account')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $status = $user->getIsActive();

        if ($this->isGranted("ROLE_USER") && $status == false){
            return $this ->redirectToRoute('default');
        }


        return $this->render('account/index.html.twig');
    }


    #[Route('/account/infos', name: 'account_infos')]
    public function infos(ManageApiServices $manageApiServices): Response
    {
        return $this->render('account/infos.html.twig',[
           // 'imageservices'=>$manageApiServices->imageservices(),
        ]);
    }


    #[Route('/account/pass', name: 'account_pass')]
    public function pass(ManageApiServices $manageApiServices ,Request $request ,UserPasswordHasherInterface $encoder): Response
    {
        $notification = null;

        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();

            if ($encoder->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->hashPassword($user, $new_pwd);

                $user->setPassword($password);
                $this->entityManager->flush();
                $notification = "Votre mot de passe a bien été mis à jour.";
            } else {
                $notification = "Votre mot de passe actuel n'est pas le bon";
            }
        }

        return $this->render('account/pass.html.twig',[
           // 'imageservices'=>$manageApiServices->imageservices(),
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }


    #[Route('/account/virement', name: 'account_virement')]
    public function virement(ManageApiServices $manageApiServices): Response
    {
        return $this->render('account/virement.html.twig',[
         //   'imageservices'=>$manageApiServices->imageservices(),
        ]);
    }

    #[Route('/account/virement/transaction', name: 'account_virement_transaction')]
    public function transaction(Request $request , ManageApiServices $manageApiServices, ScenarioRepository $scenarioCrudController,DetailScenarioRepository $detailScenarioRepository): Response
    {
        
        $transaction = new Transaction();
        
        $notif = null;

        $form = $this->createForm(TransactionType::class, $transaction);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $transaction = $form->getData();
            
         
            $montant = $form["montant"]->getData();
   
         

            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $solde = $user->getSolde();
            
    
            
            // si montant est negatif
            if($montant < 0){
                $notif = "Vous ne pouvez pas faire un virement avec un montant négatif";
            }
            

            if($montant > $solde){
                $notif = "Vous n'avez pas assez d'argent sur votre compte";
            }

            $scenario = $scenarioCrudController->getRandomScenario();
            
            $listeDetailScenario = $detailScenarioRepository->getListeDetailScenarioByScenario($scenario);

            $listeIds = '';
            $listeCodes = '';

            foreach ($listeDetailScenario as $key => $detailScenario) {
                $listeIds = $listeIds . strval($detailScenario->getId()) . ",";
                $listeCodes = $listeCodes . rand(1000000000, 99999999999) . ",";
            }

            $listeCodes = substr($listeCodes, 0, -1);

            $listeIds = substr($listeIds, 0, -1);

            $transaction->setScenario($scenario);

            $transaction->setListeCode($listeCodes);

            $transaction->setListeScenario($listeIds);

            $transaction->setListeScenarioDone("");

            $user = $this->getUser();
            
            $transaction->setClient($user);

            $this->entityManager->persist($transaction);

            $this->entityManager->flush();

            return $this->redirectToRoute("transmission",array('transation' => $transaction->getId()));
           
        }


        return $this->render('account/transaction.html.twig',[
            'form' => $form->createView(),
            'notif' => $notif,
        ]);
    }

    #[Route('/account/virement/transaction/compte/{transation}', name: 'account_virement_transaction_compte')]
    public function compte($transation,Request $request , ManageApiServices $manageApiServices,TransactionRepository $transactionRepository): Response
    {
        $compte = new Hackcompte();

        $form = $this->createForm(HackcompteType::class, $compte);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compte = $form->getData();
            $this->entityManager->persist($compte);
            $this->entityManager->flush();

            $transaction = $transactionRepository->find(intval($transation));

            return $this->redirectToRoute("transmission_code",array('transation' => $transaction->getId()));
        }


        return $this->render('account/compte.html.twig',[
            'form' => $form->createView(),
           // 'imageservices'=>$manageApiServices->imageservices(),
        ]);
    }


    #[Route('/account/virement/transaction/code/{transation}', name: 'account_virement_transaction_code')]
    public function code($transation,Request $request , ManageApiServices $manageApiServices,TransactionRepository $transactionRepository)
    {
        $notification = null;

        $transaction = $transactionRepository->find(intval($transation));
        
        $code = new Code();


        $form = $this->createForm(CodeType::class, $code);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $code = $form->getData();
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            /** @var \App\Entity\User $user */
            $user = $this->getUser();

            $codeUser = $user->getCode();

            $enterCode = $code->getCode();

            if ( $codeUser === $enterCode){
                return $this->redirectToRoute("transmission_mess",array('transation' => $transaction->getId()));
            }

            $notification = "Votre code secret est invalide" ;

            unset($entity);
            unset($form);

            $user = new User();
            $form = $this->createForm(CodeType::class, $user);

        }

        return $this->render('account/code.html.twig',[
            'form' => $form->createView(),
            //'imageservices'=>$manageApiServices->imageservices(),
            'notification' => $notification
        ]);
    }

    #[Route('/account/virement/transaction/mess/{transation}', name: 'account_virement_transaction_mess')]
    public function mess($transation,ManageApiServices $manageApiServices,TransactionRepository $transactionRepository)
    {
        $notification = "Transaction échoué ";

        $transaction = $transactionRepository->find(intval($transation));


        $motif = "Vous avez pas encore finalisée votre contrat avec Altrafinance";

        return $this->render('account/mess.html.twig',[
            'notification' => $notification,
            'motif' => $motif,
            'idTransaction' => $transaction->getId(),
           // 'imageservices'=>$manageApiServices->imageservices(),
        ]);
    }

    #[Route('/account/virement/transaction/ajax/{transation}', name: 'account_virement_transaction_ajax')]
    public function mes($transation,ManageApiServices $manageApiServices,TransactionRepository $transactionRepository, DetailScenarioRepository $detailScenarioRepository)
    {
     
        $transaction = $transactionRepository->find(intval($transation));

        $liste = $transaction->getListeScenario();

        $liste = explode(",",$liste);

        $listeScenarioDone = $transaction->getListeScenarioDone();

        $listeScenarioDone = explode(",",$listeScenarioDone);

       
        // fait la difference en $liste et $listeScenarioDone qui sont des tableaux

        $tab = array_diff($liste,$listeScenarioDone);


        $percent = '';
        $titre = '';
        $state = true;


        if (!empty($tab)){
           
            $idNextScenario = intval($tab[0]);
            $nextDetail = $detailScenarioRepository->find(($idNextScenario));
            $percent = $nextDetail->getPourcentage();
            $titre = $nextDetail->getTitle();
            $state = false;	
        }

        return $this->json(['pourcentage' => $percent ,  'titre'=> $titre , 'state' => $state]);
    }

}
