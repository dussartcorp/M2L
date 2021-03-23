<?php

namespace App\Controller;

use App\Entity\Inscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InscriptionRepository;
use App\Form\InscriptionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/inscription",name="inscription_")
 */
class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(): Response
    { 
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }


    /**
     * @Route("/atelier",name="atelier")
     * @Template("inscription/inscriptionAtelier.html.twig")
     */
    public function inscription(Request $request,EntityManagerInterface $manager)
    {
        $form=$this->createForm(InscriptionType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){

        }
        return $this->render('inscription/inscriptionAtelier.html.twig',['form'=>$form->createView(),]);
    }

}
