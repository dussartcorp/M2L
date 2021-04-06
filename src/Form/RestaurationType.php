<?php

namespace App\Form;

use App\Entity\Restauration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RestaurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateRestauration',EntityType::class,[
                'class'=>Restauration::class,
                'choice_label'=>'dateRestauration',
                'expanded'=>false,
                'multiple'=>false,])
            ->add('typesRepas',EntityType::class,[
                'class'=>Restauration::class,
                'choice_label'=>'typesRepas',
                'expanded'=>true,
                'multiple'=>true,])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restauration::class,
        ]);
    }
}
