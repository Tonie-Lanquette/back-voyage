<?php

namespace App\Form;

use App\Entity\AvBooking;
use App\Entity\AvForms;
use App\Entity\AvStatus;
use App\Entity\AvTravels;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('avTravels', EntityType::class, [
            'class' => AvTravels::class,
            'choice_label' => 'name',    
        ])
        ->add('avStatus', EntityType::class, [
            'class' => AvStatus::class,
            'choice_label' => 'name',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AvBooking::class,
        ]);
    }
}
