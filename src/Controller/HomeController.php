<?php

namespace App\Controller;

use App\Repository\CountryRepository;
use App\Service\DataGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private DataGenerator $dataGenerator;

    public function __construct(DataGenerator $dataGenerator) {
        $this->dataGenerator = $dataGenerator;
    }

    #[Route('/', name: 'app_home')]
    public function index(CountryRepository $countryRepository): Response
    {
        try {
            $this->dataGenerator->importDataFromCSV();
        } catch (\Exception $e) {
            //Ayaya
        }

        $a = array(array("nom" => "rhone", "nombre" => 69), array("nom" => "loire", "nombre" => 42)); // pour l'exemple, il faudra interroger la base
        return $this->render('home/index.html.twig', [
            'countries' => $countryRepository,
            'controller_name' => 'HomeController',
            'departements' => $a,
        ]);
    }
}
