<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $details = Action::new('detailUser', 'Voir détails', 'fas fa-eye')
        ->linkToCrudAction(Crud::PAGE_DETAIL)
            ->addCssClass('btn btn-info');


        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, $details);
    }



    public function configureFields(string $pageName): iterable
    {

        $fields = [
            IntegerField::new('numLicence', 'N° Licence'),
            EmailField::new('email', 'Adresse Mail'),
            ArrayField::new('roles')
        ];

        if ($pageName === Crud::PAGE_EDIT) {
            return [
                ArrayField::new('roles')
            ];
        } else {    
            return $fields;
        }
    }
}
