<?php

namespace App\DataFixtures;

use App\Entity\SkillCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillCategoryFixtures extends Fixture
{
    public const SKILL_CATEGORIES = [
        'backend' => ['Développeur Backend', 'Parce qu\'un code bien écrit, ça peut-être beau aussi !'],
        'frontend' => ['Frontend', 'J\'aime passionnement le CSS et j\'en suis fier'],
        'uxui' => ['UX/UI', 'Un code propre c\'est mieux avec un joli visuel'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SKILL_CATEGORIES as $skillCategoryCode => $skillCategoryData) {
            $skillCategory = new SkillCategory();
            $skillCategory->setName($skillCategoryData[0]);
            $skillCategory->setDescription($skillCategoryData[1]);
            $skillCategory->setIcon($skillCategoryCode . '.png');
            $this->addReference('category_' . $skillCategoryCode, $skillCategory);
            $manager->persist($skillCategory);
        }
        $manager->flush();
    }
}
