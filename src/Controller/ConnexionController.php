<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\GestionContact;

class ConnexionController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/mdpOublie", name="mdpOublie")
     */
    public function mdpOublie(Request $request, UserRepository $usersRepo, \Swift_Mailer $mailer)
    {
        if ($_POST) {
            $user = $usersRepo->findOneByEmail($_POST['email']);

            if (!$user) {
                $this->addFlash('warning', 'Cette adresse n\'existe pas');

                $this->redirectToRoute('app_login');
            }

            $token = md5(uniqid());

            try {
                $user->setActivationToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', 'Une erreur est survenue: ' . $e->getMessage());
                return $this->redirectToRoute('app_login');
            }

            $url = $this->generateUrl('app_reset_password', ['token' => $token]);
            $url = 'm2l-2.fr' . $url;
            GestionContact::send($user->getEmail(), 'Vous', 'R??initialisation de votre mot de passe', '<p> Bonjour, </p> 
            <p>Vous avez fait une demande de r??initialisation de mot de passe, veuillez cliquer sur le lien ci-dessou pour y acc??der :</p>
                    <a href=' . $url . '> Activer votre compte </a>', 'text/html');


            $this->addFlash('success', 'Un email de r??initialisation de mot de passe vous a ??t?? envoy??');

        };

        return $this->render('security/mdpOublie.html.twig');
    }

    /**
     * @Route("/reset-pass/{token}", name="app_reset_password")
     */
    public function resetPassword($token, Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $usersRepo)
    {
        $user = $usersRepo->findOneByToken($token);
        if (!$user) {
            $this->addFlash('warning', 'Token inconnu');
            return $this->redirectToRoute('app_login');
        }

        if ($request->isMethod('POST')) {
            $user->setActivationToken(null);

            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $user->setconfPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Mot de passe modifi?? avec succ??s');

            return $this->redirectToRoute('app_login');
        } else {
            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }
    }
}
