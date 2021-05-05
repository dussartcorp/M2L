<?php

namespace App\Controller;

use App\Entity\Inscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\InscriptionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Form\NuiteeType;
use App\Entity\Nuitee;
use App\Entity\Restauration;
use App\Entity\User;
use App\Form\InscriptionV2Type;
use App\Repository\RestaurationRepository;
use App\Service\Outils;
use DateTime;

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
     * @Route("/sejour",name="sejour")
     * @Template("inscription/inscriptionSejour.html.twig")
     */
    public function inscription(Request $request,EntityManagerInterface $manager,RestaurationRepository $repoResto)
    {   
        $user=$this->getUser();
        $uneRestauration1=New Restauration();
        $uneRestauration2=New Restauration();
        $uneRestauration3=New Restauration();
        $formInscription=$this->createForm(InscriptionV2Type::class);
        $formInscription->handleRequest($request);
        if (($formInscription->isSubmitted() && $formInscription->isValid())) {
            //var_dump($formInscription);
            $inscription=$formInscription['ateliers']->getData();
            $nuite1=$formInscription['nuite1']->getData();
            $nuite2=$formInscription['nuite2']->getdata();
            //var_dump($nuite1);
            if ($nuite2->getHotel() == null && $nuite1->getHotel() != null) {
                $nuite1->setDateNuiteee(New DateTime($_POST['date1']));
                $inscription->addNuitee($nuite1);
            } else if ($nuite2->getHotel() != null && $nuite1->getHotel() != null) {
                $nuite1->setDateNuiteee(New DateTime($_POST['date1']));
                $nuite2->setDateNuiteee(New DateTime($_POST['date2']));
                $inscription->addNuitee($nuite1);
                $inscription->addNuitee($nuite2);
            }
            $inscription->setDateInscription(new DateTime('NOW'));
            if(isset($_POST['ckcSamMidi'])){
                $uneRestauration1->setTypesRepas($_POST['ckcSamMidi']);
                $uneRestauration1->setDateRestauration(new DateTime($_POST['date1']));
                $inscription->addRestauration($uneRestauration1);
            }
            if(isset($_POST['ckcSamSoir'])){
                $uneRestauration2->setTypesRepas($_POST['ckcSamSoir']);
                $uneRestauration2->setDateRestauration(new DateTime($_POST['date1']));
                $inscription->addRestauration($uneRestauration2);
            }
            if(isset($_POST['ckcDimMidi'])){
                $uneRestauration3->setTypesRepas($_POST['ckcDimMidi']);
                $uneRestauration3->setDateRestauration(new DateTime($_POST['date2']));
                $inscription->addRestauration($uneRestauration3);
            }
            $inscription->setCompte($user);

            // var_dump($nuite2);
            $manager->persist($inscription);
            $manager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('inscription/inscriptionSejour.html.twig', ['nuites' => $formInscription->createView(),'resto1' => $resto1, 'resto2' => $resto2]);
    }



}

