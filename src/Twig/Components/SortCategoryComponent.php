<?php

namespace App\Twig\Components;

use App\Entity\SkillCategory;
use App\Repository\SkillCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent()]
final class SortCategoryComponent extends AbstractController
{
    use DefaultActionTrait;

    public const DIRECTIONS = ['up' => 1, 'down' => -1];

    #[LiveProp(writable:true)]
    public SkillCategory $skillCategory;

    public function __construct(
        private SkillCategoryRepository $skillCategoryRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function isMax(): int
    {
        return count($this->skillCategoryRepository->findAll());
    }


    #[LiveAction]
    public function changeOrder(#[LiveArg] string $direction): Response
    {
        $actualPosition = $this->skillCategory->getPosition();
        $newPosition = $actualPosition + self::DIRECTIONS[$direction];
        $toReplaceCategory = $this->skillCategoryRepository->findOneBy(['position' => $newPosition]);

        if ($toReplaceCategory instanceof SkillCategory) {
            $toReplaceCategory->setPosition($actualPosition);
            $this->skillCategory->setPosition($newPosition);
        } else {
            throw new \LogicException('Impossible de réordonner');
        }

        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_skill_category_index');
    }
}
