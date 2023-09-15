<?php

namespace App\Twig\Components;

use App\Entity\SkillCategory;
use App\Form\SkillCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent()]
final class SkillCollectionType extends AbstractController
{
    use LiveCollectionTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public SkillCategory $skillCategory;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(SkillCategoryType::class, $this->skillCategory);
    }
}
