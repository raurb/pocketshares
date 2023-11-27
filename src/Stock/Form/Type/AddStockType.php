<?php

declare(strict_types=1);

namespace PocketShares\Stock\Form\Type;

use PocketShares\StockExchange\Symbol;
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
            ->add('symbol', EnumType::class, ['class' => Symbol::class,'required' => true])
            ->add('Add', SubmitType::class);
    }
}