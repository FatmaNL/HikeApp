<?php

namespace App\Form;
use Gregwar\CaptchaBundle\Type\CaptchaType;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('refcommande',TextType::class, array('label'=>'Lieu'))
            ->add('datecommande',DateType::class, array('label'=>'Date '))
            ->add('etat',TextType::class, array('label'=>'Description '))
           // ->add('produits',TextType::class)
           //->add('catName',TextType::class, array('label' => 'Category Name','attr' => array('class' => 'form-control', 'autocomplete'=>'off'),'data_class' => null))
           ->add('captcha', CaptchaType::class);


        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
