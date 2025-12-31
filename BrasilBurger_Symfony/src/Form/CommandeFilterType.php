<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CommandeFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'Type de commande',
                'required' => false,
                'choices' => [
                    'Sur place' => 'sur_place',
                    'À emporter' => 'a_emporter',
                    'Livraison' => 'livraison',
                ],
                'placeholder' => 'Tous les types',
                'attr' => ['class' => 'form-control']
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'required' => false,
                'choices' => [
                    'En attente' => 'en_attente',
                    'Validée' => 'valide',
                    'En préparation' => 'preparation',
                    'Prête' => 'prete',
                    'Terminée' => 'termine',
                    'Annulée' => 'annule',
                ],
                'placeholder' => 'Tous les statuts',
                'attr' => ['class' => 'form-control']
            ])
            ->add('date', DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('client', EntityType::class, [
                'label' => 'Client',
                'required' => false,
                'class' => Client::class,
                'choice_label' => function (Client $client) {
                    return $client->getNom() . ' ' . $client->getPrenom();
                },
                'placeholder' => 'Tous les clients',
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
