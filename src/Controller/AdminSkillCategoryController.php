<?php

namespace App\Controller;

use App\Entity\SkillCategory;
use App\Form\SkillCategoryType;
use App\Repository\SkillCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/skill/category')]
class AdminSkillCategoryController extends AbstractController
{
    #[Route('/', name: 'app_admin_skill_category_index', methods: ['GET'])]
    public function index(SkillCategoryRepository $skillCategoryRepository): Response
    {
        return $this->render('admin_skill_category/index.html.twig', [
            'skill_categories' => $skillCategoryRepository->findBy([], ['id'=>'ASC']),
        ]);
    }

    #[Route('/new', name: 'app_admin_skill_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $skillCategory = new SkillCategory();
        $form = $this->createForm(SkillCategoryType::class, $skillCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($skillCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_skill_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_skill_category/new.html.twig', [
            'skill_category' => $skillCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_skill_category_show', methods: ['GET'])]
    public function show(SkillCategory $skillCategory): Response
    {
        return $this->render('admin_skill_category/show.html.twig', [
            'skill_category' => $skillCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_skill_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SkillCategory $skillCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SkillCategoryType::class, $skillCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_skill_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_skill_category/edit.html.twig', [
            'skill_category' => $skillCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_skill_category_delete', methods: ['POST'])]
    public function delete(Request $request, SkillCategory $skillCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$skillCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($skillCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_skill_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
