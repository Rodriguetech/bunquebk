<?php

namespace App\Controller\Admin;

use App\Entity\DetailScenario;
use App\Entity\Scenario;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DetailScenarioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DetailScenario::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            IntegerField::new('pourcentage'),
            AssociationField::new('scenario',Scenario::class)->setLabel("Scenario"),
        ];
    }
}
