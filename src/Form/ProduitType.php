<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomproduit',TextType::class, array('attr' => array('class' => 'form-control'),'data_class' => null))
            ->add('quantite',IntegerType::class, array('attr' => array('class' => 'form-control'),'data_class' => null))
            ->add('prix',TextType::class, array('attr' => array('class' => 'form-control'),'data_class' => null))
            ->add('image',FileType::class, array('constraints' => [
                new File([
                    'maxSize' => '1000000k',
                    
                ])
                ],'attr' => array('class' => 'form-control'),'data_class' => null))
            ->add('catName',TextType::class, array('label' => 'Category Name','attr' => array('class' => 'form-control', 'autocomplete'=>'off'),'data_class' => null))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
