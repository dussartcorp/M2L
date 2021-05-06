<?php

namespace App\Form;

use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Atelier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Restauration;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('dateInscription')
            ->add('ateliers',EntityType::class,[
                'class'=>Atelier::class,
                'choice_label'=>'libelle',
                'expanded'=>true,
                'multiple'=>true,
                'label'=>false,])
                ->add('restaurations',EntityType::class,[
                    'class'=>Restauration::class,                  
                    'choice_label'=>function(Restauration $resto){
                        return 'Le ' . $resto->getDateRestauration()->format('d-m-y'). ' : '. $resto->getTypesRepas();
                    },
                    'expanded'=>true,
                    'multiple'=>true,
                    'label'=>false,
                ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
