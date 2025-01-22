<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\PredictionType;

final class AssuranceController extends AbstractController
{
    #[Route('/assurance', name: 'app_assurance')]
    public function index(): Response
    {
        $form = $this->createForm(PredictionType::class);
        return $this->render('assurance/index.html.twig', [
            'controller_name' => 'AssuranceController',
            'form' => $form,
        ]);
    }
}
