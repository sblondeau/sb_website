<?php

namespace App\DataFixtures;

use App\Entity\SkillCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillCategoryFixtures extends Fixture
{
    public const SKILL_CATEGORIES = [
        'backend' => 'Développeur Backend',
        'frontend' => 'Frontend',
        'uxui' => 'UX/UI',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SKILL_CATEGORIES as $skillCategoryCode => $skillCategoryName) {
            $skillCategory = new SkillCategory();
            $skillCategory->setName($skillCategoryName);
            $skillCategory->setIcon($skillCategoryCode . '.png');
            $this->addReference('category_' . $skillCategoryCode, $skillCategory);
            $manager->persist($skillCategory);
        }
        $manager->flush();
    }
}
