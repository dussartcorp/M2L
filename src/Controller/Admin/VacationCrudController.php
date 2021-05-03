<?php

namespace App\Controller\Admin;

use App\Entity\Vacation;
use App\Repository\VacationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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


    // /**
    //  * @Route('/admin/saveVacation', name="createVacation")
    //  */
    // public function createVacation(Request $request, VacationRepository $vrepo, EntityManagerInterface $manager)
    // {
    //     $id = $request->query->get('id');
    //     $dateHeureDeb = $request->query->get('dateHeureDebut');
    //     $dateHeureFin = $request->query->get('dateHeureFin');


    //     $vacation = $vrepo->find($id);
    //     $Deb = $dateHeureDeb->format('d/n/Y');
    //     $fin = $dateHeureFin->format('d/n/Y');
    //     if ($dateHeureDeb < $dateHeureFin && $Deb === $fin) {

    //         $mois_fr = array(
    //             "", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août",
    //             "septembre", "octobre", "novembre", "décembre"
    //         );

    //         $hDeb = $dateHeureDeb->format('H:i');
    //         $hFin = $dateHeureFin->format('H:i');
    //         list($jour, $mois, $annee) = explode('/', $Deb);
    //         $vacation->setLibelle("Le " . $jour . " " . $mois_fr[$mois] . " de " . $hDeb . " à " . $hFin);
    //         $vacation->setDateHeureDebut($dateHeureDeb);
    //         $vacation->setDateHeureFin($dateHeureFin);


    //         $manager->persist($vacation);
    //         $manager->flush();
    //         $this->addFlash('success', ' La vacation a bien été enregistrée');
    //     } else {
    //         $this->addFlash('warning', 'La date de fin de la vacation n\'est pas conforme à la date de début');
    //     }
    // }

    public function configureActions(Actions $actions): Actions
    {
        // $details = Action::new('detailLicencie', 'Voir détails', 'fas fa-eye')
        // ->linkToCrudAction(Crud::PAGE_DETAIL)
        //     ->addCssClass('btn btn-info');

        // $create = Action::new('create', 'Sauvegarder', 'fas fa_check')
        // ->addCssClass('btn btn-info')
        // ->linktoRoute("createVacation", function (Vacation $vacation) {
        //     return [
        //         'id' => $vacation->getId(),
        //         'dateHeureDebut' => $vacation->getDateHeureDebut(),
        //         'dateHeureFin' => $vacation->getDateHeureFin()
        //     ];
        // });

        return $actions
        ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN);
        // ->add(Crud::PAGE_EDIT, $create);
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
