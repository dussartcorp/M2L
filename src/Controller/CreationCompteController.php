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
use App\Repository\LicencieRepository;

/**
 * @Route("/inscription/", name="creation_")
 */
class CreationCompteController extends AbstractController
{
    /**
     * @Route("compte", name="compte")
     */
    public function index(Request $request, EntityManagerInterface $manager, UserRepository $compte, UserPasswordEncoderInterface $encoder, LicencieRepository $lrepo): Response
    {
        $compte = new User();
        $form = $this->createForm(CreationCompteType::class, $compte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $numLicence = $form->get('numLicence')->getData();
            if ($lrepo->isNumLicenceValid($numLicence) === 'ok') {
                $compte->setRoles(["ROLE_INSCRIT"]);
                $mdp = $form->get('password')->getData();
                $vmdp = $form->get('confPassword')->getData();
                if ($mdp === $vmdp) {
                    $encoder = $encoder->encodePassword($compte, $mdp);
                    $compte->setPassword($encoder);
                    $manager->persist($compte);
                    $manager->flush();

                    $this->addFlash('success', " Votre demande a bien été prise en compte ! Veuillez la valider par mail ! ");
                } else {
                    $this->addFlash('warning', " Les mots de passes doivent êtres identiques !");
                };
            }else{ 
                $this->addFlash('warning', " Le numéro de licence n'est pas connu de nos services !");
            }
        }
        return $this->render('CreationCompte/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
