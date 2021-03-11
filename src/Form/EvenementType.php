<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depart')
            ->add('destination')
            ->add('nbparticipant')
            ->add('dateevenement')
            ->add('duree')
            ->add('prix')
            ->add('programme')
            ->add('contact')
            ->add('infos')
            ->add('type')
            ->add('circuit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
