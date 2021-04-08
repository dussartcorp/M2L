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
    public function index(Request $request, EntityManagerInterface $manager, UserRepository $compte, UserPasswordEncoderInterface $encoder, LicencieRepository $lrepo, \Swift_Mailer $mailer): Response
    {
        $compte = new User();
        $form = $this->createForm(CreationCompteType::class, $compte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $numLicence = $form->get('numLicence')->getData();
            if($lrepo->isNumLicenceExist($numLicence) === 'ok'){

                $this->addFlash('warning', 'Un compte est déjà créé avec ce numéro de licence');
                return $this->redirectToRoute('app_login');
            }
            if ($lrepo->isNumLicenceValid($numLicence) === 'ok') {
                $compte->setRoles(["ROLE_INSCRIT"]);
                $mdp = $form->get('password')->getData();
                $vmdp = $form->get('confPassword')->getData();
                if ($mdp === $vmdp) {
                    $encoder = $encoder->encodePassword($compte, $mdp);
                    $compte->setPassword($encoder);
                    $compte->setconfPassword($encoder);
                    
                    $compte->setActivationToken(md5(uniqid()));

                    $manager->persist($compte);
                    $manager->flush();

                    $message = (new \Swift_Message('Activation de votre compte'))
                        ->setFrom('robinbijaudy@gmail.com')
                        ->setTo($compte->getEmail())
                        ->setBody(
                            $this->renderView(
                                'emails/activation.html.twig', ['token' => $compte->getActivationToken()]
                            ),
                            'text/html'
                        )
                    ;

                    $mailer->send($message);

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

    /**
     * @Route("activation/{token}", name="activation")
     */
    public function activation($token, UserRepository $usersRepo){
        $user = $usersRepo->findOneBy((['activation_token' => $token]));

        if(!$user){
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
