<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Atelier;
use App\Repository\AtelierRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AtelierType;
use App\Form\ThemeType;
use App\Form\VacationType;
use App\Entity\Theme;
use App\Entity\Vacation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * 
 * @Route("/congres/", name="congres_")
 */
class CongresController extends AbstractController
{
    /**
     * 
     * @Route("atelier", name="atelier")
     */
    public function creationAtelier(Request $request, EntityManagerInterface $manager)
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $atelier = new Atelier();
        $theme = new Theme();
        $vacation = new Vacation();

        $form = $this->createForm(AtelierType::class, $atelier);
        $formTheme = $this->createForm(ThemeType::class, $theme);
        $formVacation = $this->createForm(VacationType::class, $vacation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($atelier);
            $manager->flush();
            $this->addFlash('success', ' L\'atelier a bien été enregistré');
            return $this->redirectToRoute('congres_atelier');
        }
        return $this->render(
            'congres/creerAtelier.html.twig',
            [
                'form' => $form->createView(),
                'formTheme' => $formTheme->createView(),
                'formVacation' => $formVacation->createView()
            ]
        );
    }

    /**
     * Route permettant de créer un thème à partir d'une modal dans atelier
     * @Route("theme", name="theme")
     */
    public function creationModalTheme(Request $request, EntityManagerInterface $manager)
    {
        $atelier = new Atelier();
        $theme = new Theme();
        $vacation = new Vacation();

        $form = $this->createForm(AtelierType::class, $atelier);
        $formTheme = $this->createForm(ThemeType::class, $theme);
        $formVacation = $this->createForm(VacationType::class, $vacation);

        $formTheme->handleRequest($request);
        if ($formTheme->isSubmitted() && $formTheme->isValid()) {

            $manager->persist($theme);
            $manager->flush();
            $this->addFlash('success', ' Le thème a bien été enregistré');
            return $this->redirectToRoute('congres_atelier');
        }
        return $this->render(
            'congres/creerAtelier.html.twig',
            [
                'form' => $form->createView(),
                'formTheme' => $formTheme->createView(),
                'formVacation' => $formVacation->createView()
            ]
        );
    }


    /**
     * Route permettant de créer un thème
     * @Route("theme/creer", name="creerTheme")
     */
    public function creationTheme(Request $request, EntityManagerInterface $manager)
    {
        $theme = new Theme();

        $formTheme = $this->createForm(ThemeType::class, $theme);

        $formTheme->handleRequest($request);
        if ($formTheme->isSubmitted() && $formTheme->isValid()) {

            $manager->persist($theme);
            $manager->flush();
            $this->addFlash('success', ' Le thème a bien été enregistré');
            return $this->redirectToRoute('congres_atelier');
        }
        return $this->render(
            'congres/creerTheme.html.twig',
            [
                'formTheme' => $formTheme->createView()
            ]
        );
    }

    /**
     * Route permettant de créer une vacation à partir d'une modal dans atelier
     * @Route("vacation", name="vacation")
     */
    public function creationModalVacation(Request $request, EntityManagerInterface $manager)
    {
        $atelier = new Atelier();
        $theme = new Theme();
        $vacation = new Vacation();

        $form = $this->createForm(AtelierType::class, $atelier);
        $formTheme = $this->createForm(ThemeType::class, $theme);
        $formVacation = $this->createForm(VacationType::class, $vacation);

        $formVacation->handleRequest($request);
        if ($formVacation->isSubmitted() && $formVacation->isValid()) {

            $dateDeb = $formVacation->get('dateHeureDebut')->getData();
            $Deb = $dateDeb->format('d/n/Y');
            $dateFin = $formVacation->get('dateHeureFin')->getData();
            $fin = $dateFin->format('d/n/Y');
            if ($dateDeb < $dateFin && $Deb === $fin) {

                $mois_fr = array(
                    "", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août",
                    "septembre", "octobre", "novembre", "décembre"
                );

                $hDeb = $dateDeb->format('H:i');
                $hFin = $dateFin->format('H:i');
                list($jour, $mois, $annee) = explode('/', $Deb);
                $vacation->setLibelle("Le " . $jour . " " . $mois_fr[$mois] . " de " . $hDeb . " à " . $hFin);


                $manager->persist($vacation);
                $manager->flush();
                $this->addFlash('success', ' La vacation a bien été enregistrée');
                return $this->redirectToRoute('congres_atelier');
            } else {
                $this->addFlash('warning', 'La date de fin de la vacation n\'est pas conforme à la date de début');
            }
        }
        return $this->render(
            'congres/creerAtelier.html.twig',
            [
                'form' => $form->createView(),
                'formTheme' => $formTheme->createView(),
                'formVacation' => $formVacation->createView()
            ]
        );
    }


    /**
     * Route permettant de créer une vacation
     * @Route("vacation/creer", name="creerVacation")
     */
    public function creationVacation(Request $request, EntityManagerInterface $manager)
    {
        $vacation = new Vacation();

        $formVacation = $this->createForm(VacationType::class, $vacation);

        $formVacation->handleRequest($request);
        if ($formVacation->isSubmitted() && $formVacation->isValid()) {

            $dateDeb = $formVacation->get('dateHeureDebut')->getData();
            $Deb = $dateDeb->format('d/n/Y');
            $dateFin = $formVacation->get('dateHeureFin')->getData();
            $fin = $dateFin->format('d/n/Y');
            if ($dateDeb < $dateFin && $Deb === $fin) {

                $mois_fr = array(
                    "", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août",
                    "septembre", "octobre", "novembre", "décembre"
                );

                $hDeb = $dateDeb->format('H:i');
                $hFin = $dateFin->format('H:i');
                list($jour, $mois, $annee) = explode('/', $Deb);
                $vacation->setLibelle("Le " . $jour . " " . $mois_fr[$mois] . " de " . $hDeb . " à " . $hFin);


                $manager->persist($vacation);
                $manager->flush();
                $this->addFlash('success', ' La vacation a bien été enregistrée');
                return $this->redirectToRoute('congres_atelier');
            } else {
                $this->addFlash('warning', 'La date de fin de la vacation n\'est pas conforme à la date de début');
            }
        }
        return $this->render(
            'congres/creerVacation.html.twig',
            [
                'formVacation' => $formVacation->createView()
            ]
        );
    }


    /**
     * Liste de tous les ateliers
     * @Route("voirtous", name="voirtous")
     */
    public function voirtous(AtelierRepository $repo)
    {
        $ateliers = $repo->findAll();

        return $this->render('congres/voirtous.html.twig', ['ateliers' => $ateliers]);
    }

    /**
     * Modification d'un atelier à partir de la liste des ateliers
     * @Route("editAtelier/{id}", name="editAtelier")
     */
    public function editAtelier(Request $request, EntityManagerInterface $manager, Atelier $atelier)
    {

        $form = $this->createForm(AtelierType::class, $atelier);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($atelier);
            $manager->flush();
            $this->addFlash('success', ' L\'atelier a bien été modifié');
            return $this->redirectToRoute('congres_voirtous');
        }
        return $this->render(
            'congres/editAtelier.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
