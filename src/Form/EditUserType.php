<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')

            ->add('nom')
            ->add('prenom')
            ->add('cin')
            ->add('age')
            ->add('sexe', ChoiceType::class, [
                'choices'  => [
                    '' => " ",
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
            ],
        ])
            ->add('adresse')
            ->add('tel')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Organisateur' => 'ROLE_ORGANISATEUR',
                    'Admin' => 'ROLE_ADMIN'
                ],
                'expanded' => false,
                'multiple' => true,
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'ACTIVE' => 'ACTIVE',
                    'DESACTIVE' => 'DESACTIVE'
                ]
            ])         
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
