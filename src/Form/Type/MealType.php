<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Entity\Meal;

class MealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('week', ChoiceType::class, [
                'label' => 'week',
                'choices' => $this->createDatesFromWeeks(),
            ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
            'translation_domain' => 'forms',
        ]);
    }
    
    private function createDatesFromWeeks(): array
    {
        $actualWeek = date('W');
        $dates = [0 => 'please choose a week'];
        
        for ($w = $actualWeek; $w <= $actualWeek + 4; $w++) {
            $start = (new \DateTime())->setISODate(date('Y'), $w)->format('d.m.y');
            $end = (new \DateTime())->setISODate(date('Y'), $w, 5)->format('d.m.y');
            $dates[$w] = 'Kalenderwoche ' . $w . ': von ' . $start . ' bis ' . $end;
        }
        
        return array_flip($dates);
    }
}