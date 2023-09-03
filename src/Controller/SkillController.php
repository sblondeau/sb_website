<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    #[Route('/skill', name: 'app_skill')]
    public function index(SkillRepository $skillRepository): Response
    {
        $skills = $skillRepository->findAll();
        return $this->render('skill/index.html.twig', [
            'skills' => $skills,
        ]);
    }
}
