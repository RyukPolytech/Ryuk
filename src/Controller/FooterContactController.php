<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FooterContactController extends AbstractController
{
    #[Route('/footer/contact', name: 'app_footer_contact')]
    public function index(): Response
    {
        return $this->render('footer_contact/index.html.twig', [
            'controller_name' => 'FooterContactController',
        ]);
    }
}
