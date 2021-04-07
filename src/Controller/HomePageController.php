<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RestaurationRepository;

class HomePageController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(RestaurationRepository $repo): Response
    {
        $date = $repo->getRestauration();
        var_dump($date);
        return $this->render('base.html.twig', [
            'date' => $date
        ]);
    }
}
