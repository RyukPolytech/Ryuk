<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TestamentController extends AbstractController
{
    #[Route('/testament', name: 'app_testament')]
    public function index(): Response
    {
        return $this->render('testament/index.html.twig', [
            'controller_name' => 'TestamentController',
        ]);
    }
}
