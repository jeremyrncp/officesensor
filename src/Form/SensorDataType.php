<?php

namespace App\Form;

use App\Entity\Sensor;
use App\Entity\SensorData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SensorDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('timestamp')
            ->add('clientName')
            ->add('mvtMessageCounter')
            ->add('blockCounter')
            ->add('payloadType')
            ->add('frameType')
            ->add('temp')
            ->add('battery')
            ->add('lowBatteryhreshold')
            ->add('XPir')
            ->add('YPir')
            ->add('ZPir')
            ->add('PirLength')
            ->add('PirSens')
            ->add('lightLevel')
            ->add('tempdLedBlink')
            ->add('ledStatus')
            ->add('sleepMode')
            ->add('keepaliveInterval')
            ->add('detectionBinSeq')
            ->add('dwinit')
            ->add('dwInter')
            ->add('dwEnd')
            ->add('prevDwinit')
            ->add('prevDwIntra')
            ->add('prevDwEnd')
            ->add('sensor', EntityType::class, [
                'class' => Sensor::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SensorData::class,
        ]);
    }
}
