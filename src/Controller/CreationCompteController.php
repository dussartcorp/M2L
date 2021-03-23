<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\CreationCompteType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class CreationCompteController extends AbstractController
{
    /**
     * @Route("/CreationCompte", name="inscription")
     */
    public function index(Request $request, EntityManagerInterface $manager, UserRepository $compte): Response
    {
        $compte = new User();
        $form = $this->createForm(CreationCompteType::class, $compte);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $compte->setRoles(["roles : inscrit"]);
            $manager->persist($compte);
            $manager->flush();

            return $this->redirectToRoute('app_login');

        }
        return $this->render('CreationCompte/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
