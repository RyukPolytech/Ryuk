<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CountryRepository;
use App\Repository\DeathCauseRepository;
use App\Repository\DeathRepository;
use App\Repository\DepartmentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/predictions')]
final class PredictionsController extends AbstractController
{

    #[Route('/', name: 'app_predictions', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('predictions/index.html.twig', [
            'controller_name' => 'PredictionsController',
        ]);
    }

    #[Route('/resultat', name: 'app_resultat', methods: ['GET', 'POST'])]
    public function resultat(
        CountryRepository $countryRepository,
        DeathCauseRepository $deathCauseRepository,
        DeathRepository $deathRepository,
        DepartmentRepository $departmentRepository
    ): Response {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $genre = $_POST['genre'];
        $age = $_POST['age'];
        $age_mois = $_POST['age_mois'];
        $age_jours = $_POST['age_jours'];
        $signe_chinois = $_POST['signe_chinois'];
        $signe_astrologique = $_POST['signe_astrologique'];
        $signe_emissaire = $_POST['signe_emissaire'];
        $pays = $_POST['pays'];
        $departement = $_POST['departement'];
        $ville = $_POST['ville'];
        $rue = $_POST['rue'];
        $etage = $_POST['etage'];
        $vert = $_POST['vert'];
        $repas = $_POST['repas'];
        $boisson = $_POST['boisson'];
        $plat_prefere = $_POST['plat_prefere'];
        $sang = $_POST['sang'];
        $anxiete = $_POST['anxiete'];
        $anxiete2 = $_POST['anxiete2'];
        $anxiete3 = $_POST['anxiete3'];

        return $this->render('predictions/resultat.html.twig', [
            'controller_name' => 'PredictionsController',
            'prenom' => $prenom,
            'nom' => $nom,
            'genre' => $genre,
            'age' => $age,
            'age_mois' => $age_mois,
            'age_jours' => $age_jours,
            'signe_chinois' => $signe_chinois,
            'signe_astrologique' => $signe_astrologique,
            'signe_emissaire' => $signe_emissaire,
            'pays' => $pays,
            'departement' => $departement,
            'ville' => $ville,
            'rue' => $rue,
            'etage' => $etage,
            'vert' => $vert,
            'repas' => $repas,
            'boisson' => $boisson,
            'plat_prefere' => $plat_prefere,
            'sang' => $sang,
            'anxiete' => $anxiete,
            'anxiete2' => $anxiete2,
            'anxiete3' => $anxiete3,
        ]);
    }

}
