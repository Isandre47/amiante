<?php

namespace App\Form;

use App\Entity\Initial;
use App\Entity\Site;
use App\Entity\Zone;
use App\Repository\ZoneRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
                    'class' => 'form-control'
                ]
            ])
            ->add('zone', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez une zone',
                // A voir si avec un form dédié pour la zone et son select, en passant une variable issu d'ici cela
                // ne serait pas mieux, à voir
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Initial::class,
        ]);
    }
}
