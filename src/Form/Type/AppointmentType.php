<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AppointmentType extends AbstractType
{
    public function getName(): string
    {
        return 'create_appointment';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_time', DateTimeType::class, [
                'label' => 'date_hour',
                'translation_domain' => 'forms',
            ])
            ->add('description', TextType::class, [
                'label' => 'description',
                'translation_domain' => 'forms',
            ])
            ->add('weekly', CheckboxType::class, [
                'label' => 'weekly',
                'translation_domain' => 'forms',
            ])
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Appointment',
            'translation_domain' => 'forms',
        ]);
    }
}