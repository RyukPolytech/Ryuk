<?php

namespace App\Controller;

use App\Repository\DeathCauseRepository;
use App\Repository\DeathRepository;
use App\Service\DataGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private DataGenerator $dataGenerator;

    public function __construct(DataGenerator $dataGenerator)
    {
        $this->dataGenerator = $dataGenerator;
    }

    #[Route('/', name: 'app_home')]
    public function index(DeathRepository $deathRepository, DeathCauseRepository $deathCauseRepository): Response
    {
        try {
            if ($deathRepository->count() === 0) {
                $this->dataGenerator->importDataFromCSV();
            }
        } catch (\Exception $e) {
            echo "data not found. Error : " . $e;
        }

        $d = array(
            "électrocuté.e",
            "écrasé.e",
            "d'un coup de foudre",
            "d'une attaque d'extraterrestre",
            "d'une attaque de dinosaures",
            "noyé.e",
            "d'hésitation",
            "parce qu'un météore vous est tombé dessus",
            "de rire",
            "d'une coupure de papier, ouch",
            "juste après avoir trouvé un ticket de loto gagnant, mince",
            "assomé.e par une enclume",
            "d'une overdose de café",
            "empoisonné.e par votre animal de compagnie",
            "d'embarras",
            "parce que l'Apocalpse vient d'arriver"
        );

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'deathsStats' => $deathRepository,
            'deathsCauses' => $deathCauseRepository,
            'listeMorts' => $d,

        ]);
    }
}
