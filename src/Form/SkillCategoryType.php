<?php

namespace App\Form;

use App\Entity\SkillCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Catégorie',
                'attr' => [
                    'placeholder' => 'Administrateur système',
                ]
            ])
            ->add('icon', TextType::class, [
                'label' => 'Icône',
                'attr' => [
                    'placeholder' => 'icon.png',
                ],
                'help' => 'ajouter l\'extension .png et mettre le fichier dans les assets'
            ])
            ->add(
                'description',
                TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'Catchprase qui va bien',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SkillCategory::class,
        ]);
    }
}
