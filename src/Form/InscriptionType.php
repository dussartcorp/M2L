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
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ateliers',AteliersType::class)
            ->add('dateNuitee1',DateTimeType::class,[
                'widget' => 'single_text',  
                'data'=> new DateTime('2021-09-14'),                       
            ])
            ->add('dateNuitee2',DateTimeType::class,[
                'widget' => 'single_text',  
                'data'=> new DateTime('2021-09-15'),                       
            ])
            ->add('hotel1',NuiteType::class)
            ->add('hotel2',NuiteType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
