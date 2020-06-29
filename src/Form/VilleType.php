<?php

namespace App\Form;

use App\Entity\Destination;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('CodeVille')
            ->add('DesVille')
            ->add('ImageVille')
            ->add('DestVille',EntityType::class,[
                'class'=>Destination::class,
                    'choice_label'=>'DesDest',
                    'label'=>'Destination'
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ville::class,
        ]);
    }
}
