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

/**
 * @Route("/congres/", name="congre_")
 */
class CreationCongresController extends AbstractController
{
    /**
     * @Route("atelier", name="atelier")
     */
    public function creationAtelier(Request $request, EntityManagerInterface $manager, AtelierRepository $repo){
        $atelier = new Atelier();
        $form = $this->createForm(AtelierType::class, $atelier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        
        $manager->persist($atelier);
        $manager->flush();
        return $this->redirectToRoute('home');
        }
        return $this->render('creation_congres/creerAtelier.html.twig',
            ['form' => $form->createView()]);
    }
}
