<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $a = array(array("nom" => "rhone", "nombre" => 69), array("nom" => "loire", "nombre" => 42)); // pour l'exemple, il faudra interroger la base
        $b = array(array("prenom" => "julien", "nombre" => 120), array("prenom" => "lilas", "nombre" => 240), array("prenom" => "merlvyn", "nombre" => 60)); // pour l'exemple, il faudra interroger la base
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'topDepartements' => $a,
            'topPrenoms' => $b,
        ]);
    }
}
