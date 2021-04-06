<?php

namespace App\Form;

use App\Entity\Restauration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\AteliersType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\NuiteType;
use App\Form\RestaurationType;
class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ateliers',AteliersType::class)
            ->add('hotel1',NuiteType::class)
            ->add('hotel2',NuiteType::class)
            ->add('restaurations1',RestaurationType::class)
            ->add('restaurations2',RestaurationType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
