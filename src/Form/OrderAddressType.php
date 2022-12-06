<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class OrderAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city')
            ->add('postcode', TextType::class, [
                'constraints' => [
                    new Regex('/[0-9]{2}\-[0-9]{3}/')
                ]
            ])            
            ->add('street')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
