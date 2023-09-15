<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $project = new Project();
        $project
            ->setTitle('Wikassur')
            ->setDate(new \DateTime())
            ->setDescription('Accompagnement de compagnie d\'assurance sur la législation et 
            la jurisprudence de sinistres incendie.')
            ->setUrl('https://wikassur.fr')
            ->setTags('Symfony, PHP, HTML, Gestion de projet, Docker')
            ->setReferral('Sylvain travaille comme un porc, il est cher et fait des blagues 
            de merde. Mais vu que personne ne va lire cette reco...')
            ->setCustomer('Emmanuel - CEO');
        $manager->persist($project);

        $project = new Project();
        $project
            ->setTitle('Comme l\'air 2 rien')
            ->setDate(new \DateTime('2022-01-22'))
            ->setDescription('Compagnie de théatre amateur propasant des comédies musicales 
            dans la région de Dijon.')
            ->setUrl('https://commelair2rien.fr')
            ->setReferral('C\'est mon loulou qui l\'a fait, c\'est forcément super !')
            ->setCustomer('Nadine - Ma maman');
        $manager->persist($project);

        $manager->flush();
    }
}
