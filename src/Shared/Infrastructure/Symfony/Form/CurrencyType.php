<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Symfony\Form;

use Money\Currencies\ISOCurrencies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CurrencyType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['choices' => $this->getChoices()]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    private function getChoices(): array
    {
        $currencies = [];
        foreach ((new ISOCurrencies()) as $currency) {
            $code = $currency->getCode();
            $currencies[$code] = $code;
        }

        return $currencies;
    }
}