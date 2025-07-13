<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', null, [
                'label' => '* Nombre',
                'attr' => [
                    'class' => 'home-input'
                ],
                'label_attr' => [
                    'class' => 'home-label'
                ]
            ])
            ->add('email', null, [
                'attr' => [
                    'class' => 'home-input' // Clase CSS para el input
                ],
                'label_attr' => [
                    'class' => 'home-label' // Clase CSS para el label
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Usuario' => 'ROLE_USER',
                    'Administrador' => 'ROLE_SUPER_ADMIN',
                ],
                'expanded' => false,  // Usa select en lugar de radio buttons
                'multiple' => true,   // Permite seleccionar múltiples roles
                'label' => '* Roles',
                'attr' => [
                    'class' => 'home-input'  // Clase CSS para el select o los checkboxes/radio buttons
                ],
                'label_attr' => [
                    'class' => 'home-label'  // Clase CSS para la etiqueta
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => '* Password',
                    'attr' => [
                        'class' => 'home-input'  // Clase CSS para el primer input
                    ],
                    'label_attr' => [
                        'class' => 'home-label'  // Clase CSS para el primer label
                    ]
                ],
                'second_options' => [
                    'label' => '* Repetir Password',
                    'attr' => [
                        'class' => 'home-input'  // Clase CSS para el segundo input
                    ],
                    'label_attr' => [
                        'class' => 'home-label'  // Clase CSS para el segundo label
                    ]
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
