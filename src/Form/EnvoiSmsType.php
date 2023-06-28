<?php

namespace App\Form;

use App\Entity\EnvoiSms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnvoiSmsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('denomination')
            ->add('dateDebutEnvoiAt', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('dateFinEnvoiAt', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('frequence', ChoiceType::class, [
                'choices'  => [
                    'Choisissez une fréquence' => '',
                    'Toutes les semaines' => 'Semaine',
                    'Chaque mois' => 'Mois',
                    'Tous les ans' => 'An',
                ],
            ])
            ->add('jourEnvoi', ChoiceType::class, [
                'choices'  => [
                    'Choisissez un jour' => '',
                    'Lundi' => 'Lundi',
                    'Mardi' => 'Mardi',
                    'Mercredi' => 'Mercredi',
                    'Jeudi' => 'Jeudi',
                    'Vendredi' => 'Vendredi',
                    'Samedi' => 'Samedi',
                    'Dimanche' => 'Dimanche',
                ],
            ])
            ->add('heureEnvoi', ChoiceType::class, [
                'choices'  => [
                    'Choisissez une heure' => '',
                    '00' => '00',
                    '01' => '01',
                    '02' => '02',
                    '03' => '03',
                    '04' => '04',
                    '05' => '05',
                    '06' => '06',
                    '07' => '07',
                    '08' => '08',
                    '09' => '09',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                    '13' => '13',
                    '14' => '14',
                    '15' => '15',
                    '16' => '16',
                    '17' => '17',
                    '18' => '18',
                    '19' => '19',
                    '20' => '20',
                    '21' => '21',
                    '22' => '22',
                    '23' => '23',
                    '24' => '24',
                ],
            ])
            ->add('minuteEnvoi', ChoiceType::class, [
                'choices'  => [
                    'Choisissez une minute' => '',
                    '00' => '00',
                    '01' => '01',
                    '02' => '02',
                    '03' => '03',
                    '04' => '04',
                    '05' => '05',
                    '06' => '06',
                    '07' => '07',
                    '08' => '08',
                    '09' => '09',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                    '13' => '13',
                    '14' => '14',
                    '15' => '15',
                    '16' => '16',
                    '17' => '17',
                    '18' => '18',
                    '19' => '19',
                    '20' => '20',
                    '21' => '21',
                    '22' => '22',
                    '23' => '23',
                    '24' => '24',
                    '25' => '25',
                    '26' => '26',
                    '27' => '27',
                    '28' => '28',
                    '29' => '29',
                    '30' => '30',
                    '31' => '31',
                    '32' => '32',
                    '33' => '33',
                    '34' => '34',
                    '35' => '35',
                    '36' => '36',
                    '37' => '37',
                    '38' => '38',
                    '39' => '39',
                    '40' => '40',
                    '41' => '41',
                    '42' => '42',
                    '43' => '43',
                    '44' => '44',
                    '45' => '45',
                    '46' => '46',
                    '47' => '47',
                    '48' => '48',
                    '49' => '49',
                    '50' => '50',
                    '51' => '51',
                    '52' => '52',
                    '53' => '53',
                    '54' => '54',
                    '55' => '55',
                    '56' => '56',
                    '57' => '57',
                    '58' => '58',
                    '59' => '59',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EnvoiSms::class,
        ]);
    }
}
