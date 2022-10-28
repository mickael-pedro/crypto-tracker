<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class CoinFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('coinname', ChoiceType::class, [
                'placeholder' => 'Sélectionner une crypto',
                'choices' => [
                    'Bitcoin (BTC)' => 'btc',
                    'Ethereum (ETH)' => 'eth',
                    'Ripple (XRP)' => 'xrp',
                ]
            ])
            ->add('quantity', NumberType::class)
        ;
    }
}
