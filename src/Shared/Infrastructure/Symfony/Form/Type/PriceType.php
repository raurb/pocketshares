<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Symfony\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price', NumberType::class, [
                'attr' => [
                    'html5' => true,
                    'min' => 0.01,
                    'scale' => 2,
                    "step" => 0.01,
                ],
                'scale' => 2,
                'label' => false,
            ])
            ->add('currency', CurrencyType::class);
    }
}