<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    #[Route('/mon-offre', name: 'app_offer')]
    public function index(): Response
    {
        return $this->render('offer/index.html.twig', []);
    }
}
