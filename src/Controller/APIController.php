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

        $db_username = "mdl";
        $db_password = "mdl";
        $db = "oci:dbname=10.10.2.10:1521/XE";
        $conn = new \PDO($db, $db_username, $db_password);
        // $conn = \oci_connect('mdl', 'mdl', '10.10.2.152:1521/MDL');

        // On récupère la liste des clubs
        $clubs = $clubsRepo->findAll();

        // On spécifie qu'on utilise un encodeur en json
        $encoders = [new JsonEncoder()];

        // On instancie le "normaliseur" pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];

        // On fait la convertion en json
        // On instancie le convertisseur
        $serializer = new Serializer($normalizers, $encoders);

        // On convertit en json
        $jsonContent = $serializer->serialize($clubs, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

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

        $encoders = [new JsonEncoder()];

        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($qualites, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

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

        $encoders = [new JsonEncoder()];

        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($qualites, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

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

        $encoders = [new JsonEncoder()];

        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($clubs, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

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

        $encoders = [new JsonEncoder()];

        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($licencies, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

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

        $encoders = [new JsonEncoder()];

        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($licencies, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
