<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', [
                'constraints' => [
                    
                ]
            ])
            ->add('password')
            ->add('apellidos')
            ->add('email')
            ->add('fechanac',Datetype::Class, [
                'format' => 'dd-MM-yyyy',
                'years' => range(date('1950'), date('Y'))
            ])
            ->add('numTar')
            ->add('titular')
            ->add('codSeg')
            ->add('direccion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
