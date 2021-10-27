<?php

namespace App\Form;

use App\Entity\Mask;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, [
                'attr' => [
                    'class' => 'form-control m-1'
                ],
                'label' => 'Référence',
            ])
            ->add('status', TextType::class, [
                'attr' => [
                    'class' => 'form-control m-1'
                ],
                'label' => 'Status',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstName',
                'attr' => [
                    'class' => 'form-control m-1'
                ],
                'label' => 'Utilisateur',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mask::class,
        ]);
    }
}
