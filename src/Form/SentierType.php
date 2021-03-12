<?php

namespace App\Form;

use App\Entity\Sentier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SentierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomsentier')
            ->add('duree')
            ->add('distance')
            ->add('difficulte')
            ->add('departsentier')
            ->add('destinationsentier')
            ->add('randonnee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sentier::class,
        ]);
    }
}
