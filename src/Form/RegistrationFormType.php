<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('apellidos')
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email([
                        'message' => 'Por favor, introduce una dirección de correo electrónico válida.',
                    ]),
                    new Regex([
                        'pattern' => '/^[^@\s]+@[^@\s]+\.[^@\s]+$/',
                        'message' => 'El correo electrónico debe tener el formato example@example.com.',
                    ]),
                ],
            ])
            ->add('fechanac', Datetype::Class, [
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