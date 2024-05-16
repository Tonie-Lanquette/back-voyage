<?php

namespace App\Form;

use App\Entity\AvCategories;
use App\Entity\AvCountries;
use App\Entity\AvTravels;
use App\Entity\AvUser;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvTravelsType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
    
            ->add('picture')
            ->add('name')
            ->add('dateStart', null, [
                'widget' => 'single_text'
            ])
            ->add('duration', null, [
                'help' => "Merci d'indiquer la durée du voyage en jours"
            ])
            ->add('price')
            ->add('avCategories', EntityType::class, [
                'class' => AvCategories::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
             ->add('avCountries', EntityType::class, [
                'class' => AvCountries::class,
                'choice_label' => 'name',
                'multiple' => true,
             ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AvTravels::class,
        ]);
    }
}
