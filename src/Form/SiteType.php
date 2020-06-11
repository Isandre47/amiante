<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 08/06/2020 02:25
 *
 */

namespace App\Form;

use App\Entity\Category;
use App\Entity\Process;
use App\Entity\Site;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteType extends AbstractType
{
    private $categoryRepository;

    /**
     * SiteType constructor.
     * @param $userRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control m-1'
                ],
                'label' =>  'Nom du chantier',
            ])
            ->add('zones', EntityType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'class' => Category::class,
                'choices' => $this->categoryRepository->categoryNotSelectedBySiteId($options['siteId'])
                ,
                'mapped' => false,
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('fibreType', ChoiceType::class, [
                'choices' => [
                    Category::AMOSITE => 'Amosite',
                    Category::CHRYSOTILE => 'Chrysolite',
                    Category::CROCIDOLITE => 'Crocidolite',
                ],
                'mapped' => false,
                'expanded' => true,
                'multiple' => true,
                'label' => 'Type de fibre',
            ])
            ->add('process', EntityType::class, [
                'class' => Process::class,
                'choice_label' => 'name',
                'mapped' => false,
                'attr' => [
                    'class' => 'form-check'
                ],
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // SiteId pour passer l'id du chantier à travers le formulaire et pouvoir le récupérer dans les options du BuildForm
        // et l'utiliser dans la requête SQL pour faire le tri pour le chantier en cours d'édition
        $resolver->setDefaults([
            'data_class' => Site::class,
            'siteId' => null
        ]);
    }
}
