<?php

namespace App\Form;

use App\Entity\Burger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class BurgerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du burger',
                'attr' => [
                    'placeholder' => 'Ex: Classic Burger',
                    'class' => 'form-control'
                ]
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Prix (FCFA)',
                'currency' => 'XOF',
                'attr' => [
                    'placeholder' => '2500',
                    'class' => 'form-control'
                ]
            ])
            ->add('image', TextType::class, [
                'label' => 'URL de l\'image',
                'required' => false,
                'attr' => [
                    'placeholder' => 'images/classic-burger.jpg',
                    'class' => 'form-control'
                ]
            ])
            ->add('archive', CheckboxType::class, [
                'label' => 'Archiver ce burger',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Burger::class,
        ]);
    }
}
