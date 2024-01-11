<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Symfony\Form\Type;

use PocketShares\Shared\Infrastructure\Symfony\Form\CurrencyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreatePortfolioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['required' => true])
            ->add('currency_code', CurrencyType::class)
            ->add('Add', SubmitType::class);
    }
}