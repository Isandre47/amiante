<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control m-1'
                ],
                'label' => 'Email'
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Droit',
                'choices' => [
                    'Utilisateur' => User::ROLE_USER,
                    'Administrateur' => User::ROLE_ADMIN,
                    'Client' => User::ROLE_CLIENT,
                ],
                'expanded' => false,
                'multiple' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control m-1'
                ]
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control m-1'
                ],
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control m-1'
                ],
                'label' => 'Nom'
            ])
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control m-1'
                ],
                'required' => false,
                'label' => 'Chantier',
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'm-1 btn btn-primary'
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
