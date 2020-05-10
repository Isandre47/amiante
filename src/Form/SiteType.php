<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Site;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('name', TextType::class)
            ->add('zones', EntityType::class, [
                'class' => Category::class,
                'choices' => $this->categoryRepository->test2($options['siteId'])
                ,
                'mapped' => false,
                'choice_label' => 'name'
            ])
            ->add('Envoyer', SubmitType::class)
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
