<?php

namespace App\Controller\Admin;

use App\Entity\Vacation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VacationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vacation::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        // $details = Action::new('detailLicencie', 'Voir détails', 'fas fa-eye')
        // ->linkToCrudAction(Crud::PAGE_DETAIL)
        //     ->addCssClass('btn btn-info');


        return $actions
            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN);
        // ->remove(Crud::PAGE_INDEX, Action::NEW)
        // ->remove(Crud::PAGE_INDEX, Action::EDIT)
        // ->remove(Crud::PAGE_DETAIL, Action::EDIT)
        // ->remove(Crud::PAGE_DETAIL, Action::DELETE)
        // ->add(Crud::PAGE_INDEX, $details);
    }

    
    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('libelle', 'Libellé'),
            DateTimeField::new('dateHeureDebut', 'Horaire de début'),
            DateTimeField::new('dateHeureFin', 'Horaire de fin')
        ];

        if ($pageName !== Crud::PAGE_INDEX) {
            unset($fields[0]);
        }
        return $fields;
    }
    
}
