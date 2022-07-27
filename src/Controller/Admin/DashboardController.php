<?php

namespace App\Controller\Admin;

use App\Entity\Devise;
use App\Entity\Hackcompte;
use App\Entity\Transaction;
use App\Entity\Temoignage;
use App\Entity\Scenario;
use App\Entity\DetailScenario;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Algrobk Client');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        
        yield MenuItem::section('Données');

        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Transactions', 'fas fa-share-square', Transaction::class);
        yield MenuItem::linkToCrud('Devises', 'fas fa-list', Devise::class);
        yield MenuItem::linkToCrud('Les comptes', 'fas fa-user', Hackcompte::class);

        yield MenuItem::section('Configuration');

        yield MenuItem::linkToCrud('Scénario', 'fab fa-app-store', Scenario::class);
        yield MenuItem::linkToCrud('Détail Scénario', 'fab fa-app-store', DetailScenario::class);

    }
}
