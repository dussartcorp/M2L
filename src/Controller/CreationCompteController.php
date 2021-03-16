<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\CreationCompteType;

class CreationCompteController extends AbstractController
{
    /**
     * @Route("/CreationCompte", name="inscription")
     */
    public function index(): Response
    {
        $compte = new User();
        $form = $this->createForm(CreationCompteType::class, $compte);
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
