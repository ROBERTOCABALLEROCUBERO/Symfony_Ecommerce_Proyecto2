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
            ->add('fechanac', Datetype::class, [
                'format' => 'dd-MMyyyy',
                'years' => range(date('1950'), date('Y'))
            ])
            ->add('numTar', null)
            ->add('titular', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, introduce el nombre del titular.',
                    ]),
                ],
            ])->add('codSeg', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 3,
                        'exactMessage' => 'El código de seguridad debe tener exactamente {{ limit }} números.',
                    ]),
                ],
            ])
            ->add('direccion', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(Calle|Avenida)\s+[a-zA-Z]+$/',
                        'message' => 'La dirección debe tener el formato "Calle/Avenida NombreCalle".',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}