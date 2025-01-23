<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PredictionsController extends AbstractController
{
    #[Route('/predictions', name: 'app_predictions')]

    public function predictions(): Response{
        if (isset($_POST['prenom']) && !empty($_POST['prenom'])) {$prenom = $_POST['prenom'];}
        else {$prenom = null;}

        if (isset($_POST['nom']) && !empty($_POST['nom'])) {$nom = $_POST['nom'];}
        else {$nom = null;}

        if (isset($_POST['genre']) && !empty($_POST['genre'])) {$genre = $_POST['genre'];}
        else {$genre = null;}

        if (isset($_POST['age']) && !empty($_POST['age'])) {$age = $_POST['age'];}
        else {$age = null;}

        if (isset($_POST['age_mois']) && !empty($_POST['age_mois'])) {$age_mois = $_POST['age_mois'];}
        else {$age_mois = null;}

        if (isset($_POST['age_jour']) && !empty($_POST['age_jour'])) {$age_jour = $_POST['age_jour'];}
        else {$age_jour = null;}

        if (isset($_POST['zodiaque_chinois']) && !empty($_POST['age_jour'])) {$zodiaque_chinois = $_POST['zodiaque_chinois'];}
        else {$zodiaque_chinois = null;}



        return $this->render('predictions/resultat.html.twig', [
            'controller_name' => 'PredictionsController',
        ]);
    }
    public function index(): Response
    {
        return $this->render('predictions/index.html.twig', [
            'controller_name' => 'PredictionsController',
        ]);
    }
}
