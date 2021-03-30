<?php

namespace App\Form;

use App\Entity\CategorieChambre;
use App\Entity\Nuite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Hotel;


class NuiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hotel',EntityType::class,[
                'class'=>Hotel::class,
                'choice_label'=>'nomHotel',
                'expanded'=>false,
                'multiple'=>false,])
            ->add('categorieChambre',EntityType::class,[
                'class'=>CategorieChambre::class,
                'choice_label'=>'libelleCategorie',
                'expanded'=>false,
                'multiple'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Nuite::class,
        ]);
    }
}
