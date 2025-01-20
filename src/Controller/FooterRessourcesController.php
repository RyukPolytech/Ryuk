<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FooterRessourcesController extends AbstractController
{
    #[Route('/footer/ressources', name: 'app_footer_ressources')]
    public function index(): Response
    {
        return $this->render('footer_ressources/index.html.twig', [
            'controller_name' => 'FooterRessourcesController',
        ]);
    }
}
