<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FooterInformationsLegalesController extends AbstractController
{
    #[Route('/footer/informations/legales', name: 'app_footer_informations_legales')]
    public function index(): Response
    {
        return $this->render('footer_informations_legales/index.html.twig', [
            'controller_name' => 'FooterInformationsLegalesController',
        ]);
    }
}
