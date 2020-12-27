<?php

namespace App\Form\Admin;

use App\Entity\TrainingTask;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TrainingTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'name',
                'translation_domain' => 'forms',
            ])
            ->add('description', TextType::class, [
                'label' => 'description',
                'translation_domain' => 'forms',
            ])
            ->add('duration', TimeType::class, [
                'label' => 'duration',
                'translation_domain' => 'forms',
            ])
            ->add('completed', CheckboxType::class, [
                'label' => 'completed',
                'required' => false,
                'translation_domain' => 'forms',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TrainingTask::class,
            'translation_domain' => 'forms',
        ]);
    }
}