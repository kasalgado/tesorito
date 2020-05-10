<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Entity\Buy;

class BuyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('end_day', DateType::class, array(
                'label' => 'final_date',
            ))
            ->add('description', TextType::class, array(
                'label' => 'description',
            ))
            ->add('completed', ChoiceType::class, [
                'label' => 'finished',
                'choices' => ['no' => 0, 'yes' => 1],
            ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Buy::class,
            'translation_domain' => 'forms',
        ]);
    }
}