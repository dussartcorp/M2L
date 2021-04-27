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
        $restauration=$repoResto->getRestauration();
        $resto1=[];
        $resto2=[];
        foreach($restauration as $item){
    
            if(count($item['typeRepas'])==2){
                $resto1=$item;
            }
            else if(count($item['typeRepas'])<2){
                $resto2=$item;
            }
            
        }
        $inscription= New Inscription();
        $Nuiteee1 = new Nuitee();
        $Nuiteee2 = new Nuitee();
        $uneRestauration1=New Restauration();
        $uneRestauration2=New Restauration();
        $uneRestauration3=New Restauration();
        $formNuiteee1 = $this->createForm(NuiteeType::class, $Nuiteee1);
        $formNuiteee2 = $this->createForm(NuiteeType::class, $Nuiteee2);
        $form=$this->createForm(InscriptionType::class,$inscription);
        $form->handleRequest($request);
        $formNuiteee1->handleRequest($request);
        $formNuiteee2->handleRequest($request);
        if (($form->isSubmitted() && $form->isValid()) && ($formNuiteee1->isSubmitted() && $formNuiteee1->isValid()) && ($formNuiteee2->isSubmitted() && $formNuiteee2->isValid())) {
            if ($Nuiteee2->getHotel() == null && $Nuiteee1->getHotel() != null) {
                $inscription->addNuitee($Nuiteee1);
            } else if ($Nuiteee2->getHotel() != null && $Nuiteee1->getHotel() != null) {
                $inscription->addNuitee($Nuiteee1);
                $inscription->addNuitee($Nuiteee2);
            }
            $inscription->setDateInscription(new DateTime('NOW'));
            if(isset($_POST['ckcSamMidi'])){
                $uneRestauration1->setTypesRepas($_POST['ckcSamMidi']);
                $uneRestauration1->setDateRestauration(New DateTime($_POST['date1']));
                $uneRestauration1->setInscriptions($inscription);
                $inscription->addRestauration($uneRestauration1);
            }
            if(isset($_POST['ckcSamSoir'])){
                $uneRestauration2->setTypesRepas($_POST['ckcSamSoir']);
                $uneRestauration2->setDateRestauration(new DateTime($_POST['date1']));
                $uneRestauration2->setInscriptions($inscription);
                $inscription->addRestauration($uneRestauration2);
            }
            if(isset($_POST['ckcDimMidi'])){
                $uneRestauration3->setTypesRepas($_POST['ckcDimMidi']);
                $uneRestauration3->setDateRestauration(New DateTime($_POST['date2']));
                $uneRestauration3->setInscriptions($inscription);
                $inscription->addRestauration($uneRestauration3);
            }
            $inscription->setCompte($user);
            $manager->persist($inscription);
            $manager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('inscription/inscriptionSejour.html.twig', ['form' => $form->createView(), 'Nuiteee1' => $formNuiteee1->createView(), 'Nuiteee2' => $formNuiteee2->createView(), 'resto1' => $resto1, 'resto2' => $resto2]);
    }



}

