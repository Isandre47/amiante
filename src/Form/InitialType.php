<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 22/05/2020 20:06
 *
 */

namespace App\Form;

use App\Entity\Initial;
use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InitialType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location', TextType::class, [
                'attr' => [
                    'class' => 'form-control m-1'
                ],
                'label' => 'Lieu de prélèvement',
            ])
            ->add('zone', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez une zone',
                // A voir si avec un form dédié pour la zone et son select, en passant une variable issu d'ici cela
                // ne serait pas mieux, à voir
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control m-1'
                ],
                'label' => 'Chantier'
            ])
            ->add('date', DateType::class, [
                'label' => 'Date',
                'html5'=> false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-1',
                ],
                'format' => 'dd-MM-yyyy',
            ])
            ->add('rate', TextType::class, [
                'label' => 'Seuil attendu',
                'attr' => [
                    'class' => 'form-control m-1',
                ],
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Initial::class,
        ]);
    }
}
