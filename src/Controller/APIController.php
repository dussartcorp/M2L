<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClubRepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Repository\QualiteRepository;
use App\Repository\LicencieRepository;

/**
 * @Route("/api/", name="api_")
 */
class APIController extends AbstractController
{
    /**
     * @Route("clubs/liste", name="listeClubs", methods={"GET"})
     * Recupère la liste de tous les clubs
     */
    public function listeClubs(ClubRepository $clubsRepo)
    {

        // $db_username = "mdl";
        // $db_password = "mdl";
        // $db = "oci:dbname=10.10.2.10:1521/XE";
        // $conn = new \PDO($db, $db_username, $db_password);
        // // $conn = \oci_connect('mdl', 'mdl', '10.10.2.152:1521/MDL');

        // On récupère la liste des clubs
        $clubs = $clubsRepo->findAll();

        //On encode en json en utf8
        $jsonContent = json_encode($clubs, JSON_UNESCAPED_UNICODE);

        // On instancie la réponse
        $response = new Response($jsonContent);

        //On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');

        // On envoie la réponse
        return $response;
    }

    /**
     * @Route("qualites/liste", name="listeQualites", methods={"GET"})
     * Recupère la liste de toutes les qualités
     */
    public function listeQualites(QualiteRepository $qualitesRepo)
    {
        // On récupère la liste des qualités
        $qualites = $qualitesRepo->findAll();

        $jsonContent = json_encode($qualites, JSON_UNESCAPED_UNICODE);

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("qualites/liste/{id}", name="listeQualitesLicencie", methods={"GET"})
     * Recupère la qualité d'un licencie précisé
     */
    public function listeQualitesLicencie($id, QualiteRepository $qualitesRepo)
    {
        // On récupère la liste des qualités en fonction d'un licencié
        $qualites = $qualitesRepo->qualiteLicencie($id);

        $jsonContent = json_encode($qualites, JSON_UNESCAPED_UNICODE);

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("clubs/liste/{id}", name="listeClubsLicencie", methods={"GET"})
     * Recupère le club d'un licencie précisé
     */
    public function listeClubsLicencie($id, ClubRepository $clubsRepo)
    {
        // On récupère la liste des clubs en fonction d'un licencié
        $clubs = $clubsRepo->clubLicencie($id);

        $jsonContent = json_encode($clubs, JSON_UNESCAPED_UNICODE);

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("info/licencie", name="infoLicencies", methods={"GET"})
     * Recupère la liste des licenciés avec leur qualité et leur club
     */
    public function InfoLicencies(LicencieRepository $licencieRepo)
    {
        // On récupère la liste des licenciés avec leur qualité et leur club
        $licencies = $licencieRepo->infoLicencies();

        $jsonContent = json_encode($licencies, JSON_UNESCAPED_UNICODE);

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("info/licencie/{id}", name="infoLicencie", methods={"GET"})
     * Recupère le licencié précisé avec sa qualité et son club
     */
    public function InfoLicencie($id, LicencieRepository $licencieRepo)
    {
        // On récupère le licencié précisé avec sa qualité et son club
        $licencies = $licencieRepo->infoLicencie($id);

        $jsonContent = json_encode($licencies, JSON_UNESCAPED_UNICODE);

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("info/licencie/atelier/{id}", name="infoLicencieAtelier", methods={"GET"})
     * Recupère les infos atelier du licencié précisé 
     */
    public function InfoLicencieAtelier($id, LicencieRepository $licencieRepo)
    {
        // On récupère le licencié précisé avec sa qualité et son club
        $licencies = $licencieRepo->InfoLicencieAtelier($id);

        $jsonContent = json_encode($licencies, JSON_UNESCAPED_UNICODE);

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("info/licencie/restauration/{id}", name="infoLicencieRestauration", methods={"GET"})
     * Recupère les infos restauration du licencié précisé 
     */
    public function InfoLicencieRestauration($id, LicencieRepository $licencieRepo)
    {
        // On récupère le licencié précisé avec sa qualité et son club
        $licencies = $licencieRepo->InfoLicencieRestauration($id);

        $jsonContent = json_encode($licencies, JSON_UNESCAPED_UNICODE);

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
