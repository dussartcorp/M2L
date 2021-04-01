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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/inscription/", name="creation_")
 */
class CreationCompteController extends AbstractController
{
    /**
     * @Route("compte", name="compte")
     */
    public function index(Request $request, EntityManagerInterface $manager, UserRepository $compte, UserPasswordEncoderInterface $encoder): Response
    {
        $compte = new User();
        $form = $this->createForm(CreationCompteType::class, $compte);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $compte->setRoles(["ROLE_INSCRIT"]);
            $mdp = $form->get('password')->getData();
            $vmdp = $form->get('confPassword')->getData();
            if($mdp === $vmdp){
            $encoder = $encoder->encodePassword($compte, $mdp);
            $compte->setPassword($encoder);
            $manager->persist($compte);
            $manager->flush();

            return $this->redirectToRoute('app_login');
            }
            else
            { 
                echo '<div class="alert alert-danger" role="alert"> Les mots de passes doivent êtres identiques ! </div>';
            };
        }
        return $this->render('CreationCompte/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
