<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;

class ContactType extends AbstractType
{
    public CONST ANSWER = 22;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Bilbo Baggins',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'placeholder' => 'bilbo@baggins.fr',
                ],
                'help' => 'Qui ne sera utilisé par personne d\'autre et à aucune autre fin que de vous répondre',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Votre message',
                'help' => 'Me poser une question, me parler d\'un projet ? N\'hésitez pas'
            ])
            ->add('question', NumberType::class, [
                'label' => 'Vingt-cinq moins trois ?',
                'help' => 'Donnez le résultat de l\'opération si vous n\'êtes pas un robot',
                'html5' => true,
                'scale' => 1,
                'mapped' => false,
                'constraints' => [
                    new EqualTo(value: self::ANSWER, message: 'La valeur est inexacte'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
