<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Regex;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('password')
            ->add('apellidos')
            ->add('email', EmailType::class, [
                'constraints' => [
                    new UniqueEntity([
                        'fields' => 'email',
                        'message' => 'Este correo electrónico ya está registrado en nuestra base de datos.'
                    ]),
                ],
            ])
            ->add('fechanac',Datetype::Class, [
                'format' => 'dd-MMyyyy',
                'years' => range(date('1950'), date('Y'))
            ])
            ->add('numTar', null, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z]{2}[0-9]{22}$/',
                        'message' => 'El número de tarjeta debe comenzar con dos letras seguidas de 22 números.'
                    ]),
                ],
            ])
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
