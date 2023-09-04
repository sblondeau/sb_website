<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SkillFixtures extends Fixture implements DependentFixtureInterface
{
    public const SKILLS = [
        'backend' => [
            'PHP 8',
            'Spécialisation Symfony 6',
            'Qualité logicielle (SOLID, TDD, KISS)',
            'MySQL, PostgreSQL',
            'Api platform',
        ],
        'frontend' => ['JS', 'CSS', 'HTML'],
        'uxui' => ['Figma', 'Inkscape'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SKILLS as $category => $skills) {
            foreach ($skills as $skillName) {
                $skill = new Skill();
                $skill->setName($skillName);
                $skill->setCategory($this->getReference('category_' . $category));
                $manager->persist($skill);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SkillCategoryFixtures::class,
        ];
    }
}
