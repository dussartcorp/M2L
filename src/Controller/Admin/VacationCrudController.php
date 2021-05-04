<?php

namespace App\Controller\Admin;

use App\Entity\Vacation;
use App\Repository\VacationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
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
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::NEW);

    }
    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('libelle', 'Libellé'),
            DateTimeField::new('dateHeureDebut', 'Horaire de début'),
            DateTimeField::new('dateHeureFin', 'Horaire de fin')
        ];


        return $fields;
    }
    
}
