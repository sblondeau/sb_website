<?php

namespace App\Controller;

use App\Repository\SkillCategoryRepository;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    #[Route('/skill', name: 'app_skill')]
    public function index(SkillCategoryRepository $skillCategoryRepository): Response
    {
        $skillCategories = $skillCategoryRepository->findBy([], ['position' => 'ASC']);
        return $this->render('skill/index.html.twig', [
            'skillCategories' => $skillCategories,
        ]);
    }
}
