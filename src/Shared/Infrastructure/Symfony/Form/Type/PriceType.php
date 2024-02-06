<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Symfony\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', NumberType::class, ['attr' => ['html5' => true]])
            ->add('currency', CurrencyType::class);
    }
}