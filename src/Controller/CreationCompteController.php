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
use App\Service\GestionContact;

/**
 * @Route("/inscription/", name="creation_")
 */
class CreationCompteController extends AbstractController
{
    /**
     * @Route("compte", name="compte")
     */
    public function index(Request $request, EntityManagerInterface $manager, UserRepository $compte, UserPasswordEncoderInterface $encoder, LicencieRepository $lrepo, \Swift_Mailer $mailer): Response
    {
        $compte = new User();
        $form = $this->createForm(CreationCompteType::class, $compte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $numLicence = $form->get('numLicence')->getData();
            if ($lrepo->isNumLicenceExist($numLicence) === 'ok') {

                $this->addFlash('warning', 'Un compte est déjà créé avec ce numéro de licence');
            }
            else if ($lrepo->isMailExist($form->get('Email')->getData()) === 'ok') {

                $this->addFlash('warning', 'Un compte est déjà créé avec cette adresse mail');
            }
            else if ($lrepo->isNumLicenceValid($numLicence) === 'ok') {
                $compte->setRoles(["ROLE_USER"]);
                $mdp = $form->get('password')->getData();
                $vmdp = $form->get('confPassword')->getData();
                if ($mdp === $vmdp) {
                    $encoder = $encoder->encodePassword($compte, $mdp);
                    $compte->setPassword($encoder);
                    $compte->setconfPassword($encoder);

                    $compte->setActivationToken(md5(uniqid()));

                    $token = $compte->getActivationToken();

                    $url = $this->generateUrl('creation_activation', ['token' => $token]);
                    $url = 'm2l-2.fr' . $url;
                    GestionContact::send($form->get('Email')->getData(), 'Vous', 'Activation de votre compte', '<p> Bonjour, </p> 
                    <p>Vous vous êtes inscrit sur notre site, veuillez cliquer sur le lien ci-dessou pour l\'activer : </p>
                    <a href=' . $url . '> Activer votre compte </a>' , 'text/html');

                    $manager->persist($compte);
                    $manager->flush();

                    $id = $lrepo->recupIdCompte($numLicence);
                    $lrepo->addIdCompte($numLicence, $id[0]['id']);


                    $this->addFlash('success', " Votre demande a bien été prise en compte ! Veuillez la valider par mail ! ");
                } else {
                    $this->addFlash('warning', " Les mots de passes doivent êtres identiques !");
                };
            } else {
                $this->addFlash('warning', " Le numéro de licence n'est pas connu de nos services !");
            }
        }
        return $this->render('CreationCompte/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("activation/{token}", name="activation")
     */
    public function activation($token, UserRepository $usersRepo)
    {
        $user = $usersRepo->findOneBy((['activation_token' => $token]));

        if (!$user) {
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        $user->setActivationToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Vous avez bien activé votre compte');

        return $this->redirectToRoute('app_login');
    }
}
