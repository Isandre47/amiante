<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Equipment;
use App\Entity\Site;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentType extends AbstractType
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
                'label' => 'Nom',
            ])
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'choice_label' =>  'name',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Chantier',
                'required' => false,
                'placeholder' => 'Dépôt',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choices' => $this->categoryRepository->categoryEquipment(),
                'choice_label' => 'name',
                'label' => 'Catégories',
                'attr' => [
                    'class' => 'form-control m-1',
                ],
            ])
            ->add('number', IntegerType::class, [
                'label' => 'Nombre',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('status', TextType::class, [
                'label' => 'Etat',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipment::class,
        ]);
    }
}
