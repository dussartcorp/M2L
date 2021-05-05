<?php

namespace App\Form;

use App\Entity\Restauration;
use App\Repository\RestaurationRepository;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RestaurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('typesRepas',EntityType::class,[
            'label'=>'Restauration',
            'class'=>Restauration::class,
            'choice_label'=>function(Restauration $resto){
                return 'Le ' . $resto->getDateRestauration()->format('d-m-y'). ' : '. $resto->getTypesRepas();
            },
            'expanded'=>true,
            'multiple'=>true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restauration::class,
        ]);
    }
}
