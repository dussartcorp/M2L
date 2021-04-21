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

/**
 * @Route("/congres/", name="congres_")
 */
class CreationCongresController extends AbstractController
{
    /**
     * @Route("atelier", name="atelier")
     */
    public function creationAtelier(Request $request, EntityManagerInterface $manager, AtelierRepository $repo){
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
            return $this->redirectToRoute('home');
        }
        return $this->render('creation_congres/creerAtelier.html.twig',
            [
                'form' => $form->createView(),
                'formTheme' => $formTheme->createView(),
                'formVacation' => $formVacation->createView()
            ]
        );
    }

    /**
     * @Route("theme", name="theme")
     */
    public function creationTheme(Request $request, EntityManagerInterface $manager)
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
            'creation_congres/creerAtelier.html.twig',
            [
                'form' => $form->createView(),
                'formTheme' => $formTheme->createView(),
                'formVacation' => $formVacation->createView()
            ]
        );
    }

    /**
     * @Route("vacation", name="vacation")
     */
    public function creationVacation(Request $request, EntityManagerInterface $manager)
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
            'creation_congres/creerAtelier.html.twig',
            [
                'form' => $form->createView(),
                'formTheme' => $formTheme->createView(),
                'formVacation' => $formVacation->createView()
            ]
        );
    }


    /**
     * @Route("ajout/themes/{libelle}", name="ajout_themes_ajax", methods={"POST"})
     */
    public function createThemesAjax(string $libelle, EntityManagerInterface $manager) : Response
    {
        $theme = new Theme();
        $theme->setLibelle(trim(strip_tags($libelle)));
        $manager->persist($theme);
        $manager->flush();
        $id = $theme->getId();
        return new JsonResponse(['id' => $id]);
    }
}
