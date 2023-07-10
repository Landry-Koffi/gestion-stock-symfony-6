<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Sorties;
use App\Repository\ProduitRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('produits', EntityType::class, [
                'class' => Produit::class,
                'query_builder' => function (ProduitRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.libelle', 'ASC');
                },
                'choice_label' => function (Produit $product) {
                    return sprintf('%s (%s)', $product->getLibelle(), $product->getNumeroArticle());
                }
            ])
            ->add('quantite')
            //->add('prixUnitaire')
            //->add('prixTotal')
            ->add('motif', ChoiceType::class, [
                'choices'  => [
                    'Choisissez un modif' => '',
                    'Volé' => 'Volé',
                    'Périmé' => 'Périlé',
                    'Endommagé' => 'Endommagé',
                    'Offert' => 'Offert',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
