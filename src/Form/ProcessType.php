<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 08/06/2020 02:25
 *
 */

namespace App\Form;

use App\Entity\Process;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProcessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du processus',
                'attr' => [
                    'class' => 'form-control m-1'
                ],
            ])
            ->add('reference', TextType::class, [
                'label' => 'Réference',
                'attr' => [
                    'class' => 'form-control m-1'
                ],
            ])
            ->add('processing', TextareaType::class, [
                'label' => 'Description du processus',
                'attr' => [
                    'class' => 'form-control m-1'
                ],
            ])
            ->add('rate', TextType::class, [
                'label' => 'Seuil attendu à priori',
                'attr' => [
                    'class' => 'form-control m-1'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Process::class,
            'inherit_data' => true,
        ]);
    }
}
