<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use App\Repository\SkillCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SkillController extends AbstractController
{
    public const CV_PATH_NAME = 'CV_Sylvain-Blondeau_LeadDev-PHP-Symfony.pdf';

    #[Route('/mes-competences', name: 'app_skill')]
    public function index(SkillCategoryRepository $skillCategoryRepository): Response
    {
        $skillCategories = $skillCategoryRepository->findBy([], ['position' => 'ASC']);
        return $this->render('skill/index.html.twig', [
            'skillCategories' => $skillCategories,
        ]);
    }

    #[Route('/cv', name: 'app_cv')]
    public function cv()
    {
        $response =  new BinaryFileResponse('../assets/files/' . self::CV_PATH_NAME);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            self::CV_PATH_NAME
        );
        return $response;
    }
}