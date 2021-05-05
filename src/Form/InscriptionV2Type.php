<?php

namespace App\Form;

use App\Entity\Restauration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\NuiteeType;
use App\Form\InscriptionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class InscriptionV2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ateliers',InscriptionType::class)
            ->add('nuite1',NuiteeType::class)
            ->add('nuite2',NuiteeType::class)
            ->add('resto',RestaurationType::class)
            //->add('resto2',RestaurationType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
