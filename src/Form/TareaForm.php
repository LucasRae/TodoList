<?php

namespace App\Form;

use App\Entity\Tarea;
use App\Entity\Tipo;
use App\Entity\Admin; // <-- Agregado aquí
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TareaForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', null, [
                'label' => 'Título de la tarea',
                'attr' => ['class' => 'form-control']
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 4,
                    'placeholder' => 'Describe brevemente la tarea...'
                ]
            ])
            ->add('fecha_creacion', DateType::class, [
                'label' => 'Fecha de creación',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('fecha_final', DateType::class, [
                'label' => 'Fecha límite',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('estado', CheckboxType::class, [
                'label' => '¿Completada?',
                'required' => false,
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('tipo', EntityType::class, [
                'class' => Tipo::class,
                'choice_label' => 'nombre',
                'label' => 'Tipo de tarea',
                'expanded' => true,
                'multiple' => false,
                'attr' => ['class' => 'form-check']
            ])
            ->add('user', EntityType::class, [
                'class' => Admin::class,
                'choice_label' => 'nombre',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Usuarios asignados',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tarea::class,
        ]);
    }
}
