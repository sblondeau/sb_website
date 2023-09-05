<?php

namespace App\DataFixtures;

use App\Entity\SkillCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillCategoryFixtures extends Fixture
{
    public const SKILL_CATEGORIES = [
        'backend' => ['Développeur Backend', 'Parce qu\'un code bien écrit, ça peut-être beau aussi !'],
        'frontend' => ['Frontend', 'J\'aime passionnement le CSS et je n\'ai pas peur de le dire'],
        'uxui' => ['UX/UI', 'Ergonomie, accessibilité, ça n\'empêche pas de faire joli'],
        'devops' => ['Devops', 'Automatisation'],
        'project' => ['Gestion de projet', '7 ans de formation, +100 projets élèves gérés'],
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
