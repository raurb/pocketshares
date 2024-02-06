<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\Symfony\Form\Type;

use PocketShares\Shared\Infrastructure\Symfony\Form\Type\CurrencyType;
use PocketShares\Stock\Domain\MarketSymbol;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['required' => true])
            ->add('ticker', TextType::class, ['required' => true])
            ->add('market_symbol', EnumType::class, ['class' => MarketSymbol::class, 'required' => true, 'label' => 'Market symbol'])
            ->add('currency', CurrencyType::class)
            ->add('Add', SubmitType::class);
    }
}