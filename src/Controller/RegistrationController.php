<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $notification = null;
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user = $form->getData();

            $search_uuid = $this->entityManager->getRepository(User::class)->findOneByUuid($user->getUuid());
            $search_email  = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (!$search_uuid && !$search_email) {
                $password = $userPasswordHasher->hashPassword($user,$user->getPassword());
                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                unset($entity);
                unset($form);

                $user = new User();
                $form = $this->createForm(RegistrationFormType::class, $user);

                $notification = "Votre inscription s'est correctement déroulée";

            } else {
                $notification = "L'identifiant et l'email  que vous avez renseigné existe déjà";
            }

        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification,
        ]);
    }
}
