<?php

namespace App\Form;

use App\Entity\Initial;
use App\Entity\Zone;
use App\Repository\ZoneRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InitialType extends AbstractType
{
    private $zoneRepository;

    /**
     * InitialType constructor.
     * @param $zoneRepository
     */
    public function __construct(ZoneRepository $zoneRepository)
    {
        $this->zoneRepository = $zoneRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location')
            ->add('zone', EntityType::class, [
                'class' => Zone::class,
                'choices' => $this->zoneRepository->findBy(['site' => '1']),
                'choice_label' => 'category.name'
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
