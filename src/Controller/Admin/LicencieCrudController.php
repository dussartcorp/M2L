<?php

namespace App\Controller\Admin;

use App\Entity\Licencie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LicencieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Licencie::class;
    }


    public function configureActions(Actions $actions): Actions
    {
        $details = Action::new('detailLicencie', 'Voir détails', 'fas fa-eye')
            ->linkToCrudAction(Crud::PAGE_DETAIL)
            ->addCssClass('btn btn-info');


        return $actions
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
            ->add(Crud::PAGE_INDEX, $details);
    }


    public function configureFields(string $pageName): iterable
    {

        $dateAdhesion = DateTimeField::new('dateAdhesion', 'Date d\'adhésion');

        $compte = AssociationField::new('compte', 'Compte');


        $fields = [
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            TextField::new('adresse1', 'Adresse'),
            TextField::new('cp', 'Code Postal'),
            TextField::new('ville', "Ville"),
            TextField::new('tel', "N° tel"),
            AssociationField::new('laQualite', 'Qualité'),
            AssociationField::new('leClub', 'Club')
        ];

        if ($pageName === Crud::PAGE_EDIT) {
            $fields[] = $dateAdhesion;
            $fields[] = $compte;
        }

        return $fields;
    }
}
