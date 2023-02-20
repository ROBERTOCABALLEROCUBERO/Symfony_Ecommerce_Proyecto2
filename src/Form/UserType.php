<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Regex;
use App\Form\Email;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor ingrese su contraseña.'
                    ]),
                    new Length([
                        'min' => 8,
                        'max' => 32,
                        'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres.',
                        'maxMessage' => 'La contraseña no puede tener más de {{ limit }} caracteres.'
                    ]),
                    new Callback(['callback' => function ($password, ExecutionContextInterface $context) {
                        $uppercase = preg_match('/[A-Z]/', $password);
                        $lowercase = preg_match('/[a-z]/', $password);
                        $number    = preg_match('/[0-9]/', $password);
                        $specialChars = preg_match('/[^\w]/', $password);
        
                        if (!$uppercase || !$lowercase || !$number || !$specialChars) {
                            $context->buildViolation('La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.')
                                ->addViolation();
                        }
                    },
                    'message' => 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.'
                ]),
            ],
        ])
            ->add('apellidos')
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                        'message' => 'El correo electrónico debe tener el formato example@example.com.',
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
