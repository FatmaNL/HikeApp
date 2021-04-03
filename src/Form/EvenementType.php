<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Sentier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomevenement', TextType::class, ['required' => true])
            ->add('depart')
            ->add('destination')
            ->add('nbparticipant')
            ->add('dateevenement')
            ->add('duree')
            ->add('prix')
            ->add('programme')
            ->add('contact')
            ->add('infos')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer image',
                'download_label' => 'Telecharger',
                'download_uri' => true,
                'image_uri' => true,
                'imagine_pattern' => null,
                'asset_helper' => true,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => ['Randonnée' => 'Randonnee', 'Camping' => 'Camping']
            ])
            ->add('circuit')
            ->add('sentiers', EntityType::class, [
                'class' => Sentier::class,
                'choice_label' => 'nomsentier',
                'multiple' => true,
                'expanded' => false
            ])

            ->add('transport', TransportType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
