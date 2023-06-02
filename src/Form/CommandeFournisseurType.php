<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\CommandeFournisseur;
use App\Entity\Fournisseur;
use App\Repository\ClientRepository;
use App\Repository\FournisseurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeFournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('observation')
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'query_builder' => function (FournisseurRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.libelle', 'ASC');
                },
                'choice_label' => function (Fournisseur $client) {
                    return sprintf('%s (%s)', $client->getLibelle(), $client->getCode());
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommandeFournisseur::class,
        ]);
    }
}
