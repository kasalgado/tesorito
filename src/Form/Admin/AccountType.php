<?php

namespace App\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\User;
use App\Entity\Money as Entity;
use App\Service\Money;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ])
            ->add('trans_type', ChoiceType::class, [
                'label' => 'type',
                'choices' => [
                    'deposit' => Money::TRANSACTION_DEPOSIT,
                    'withdraw' => Money::TRANSACTION_WITHDRAW,
                ],
            ])
            ->add('amount', NumberType::class, [
                'label' => 'value',
            ])
            ->add('description', TextType::class, [
                'label' => 'description',
            ]);
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entity::class,
            'translation_domain' => 'forms',
        ]);
    }
}