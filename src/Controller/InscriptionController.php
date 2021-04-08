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
use App\Form\NuiteType;
use App\Entity\Nuite;
use App\Entity\Restauration;
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
        $nuitee1=New Nuite();
        $nuitee2=New Nuite();
        $uneRestauration1=New Restauration();
        $uneRestauration2=New Restauration();
        $uneRestauration3=New Restauration();
        $formNuitee1=$this->createForm(NuiteType::class,$nuitee1);
        $formNuitee2=$this->createForm(NuiteType::class,$nuitee2);
        $form=$this->createForm(InscriptionType::class,$inscription);
        $form->handleRequest($request);
        $formNuitee1->handleRequest($request);
        $formNuitee2->handleRequest($request);
        if(($form->isSubmitted()&&$form->isValid())&&($formNuitee1->isSubmitted()&&$formNuitee1->isValid())&&($formNuitee2->isSubmitted()&&$formNuitee2->isValid())){   
            if($nuitee2->getHotel()==null && $nuitee1->getHotel()!=null){
                $inscription->addNuitee($nuitee1);
            }
            else if($nuitee2->getHotel()!=null && $nuitee1->getHotel()!=null){
                $inscription->addNuitee($nuitee1);
                $inscription->addNuitee($nuitee2);
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
            echo '<h1>'. $inscription->getRestaurations()[0]->getDateRestauration()->format('Y-m-d') . '</h1>';
        }
        return $this->render('inscription/inscriptionSejour.html.twig',['form'=>$form->createView(),'nuitee1'=>$formNuitee1->createView(),'nuitee2'=>$formNuitee2->createView(),'resto1'=>$resto1,'resto2'=>$resto2]);
    }



}

