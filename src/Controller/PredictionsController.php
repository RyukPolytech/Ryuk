<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PredictionsController extends AbstractController
{
    #[Route('/predictions', name: 'app_predictions')]
    public function index(): Response
    {
        return $this->render('predictions/index.html.twig', [
            'controller_name' => 'PredictionsController',
        ]);
    }
}
