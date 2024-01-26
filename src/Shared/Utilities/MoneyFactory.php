<?php

declare(strict_types=1);

namespace PocketShares\Shared\Utilities;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use PocketShares\Stock\Domain\Exception\UnknownCurrencyException;

class MoneyFactory
{
    public static function create(int|string $amount, string $currencyCode): Money
    {
        $currency = new Currency($currencyCode);
        if (!(new ISOCurrencies())->contains($currency)) {
            throw new UnknownCurrencyException($currency->getCode());
        }

        return new Money((string)($amount), $currency);
    }

    public static function fromJson(string $json): Money
    {
        $decoded = json_decode($json, false, 512, JSON_THROW_ON_ERROR);
        if (!isset($decoded['amount'], $decoded['currency'])) {
            throw new \RuntimeException(\sprintf('Cannot transform json "%s" into Money object.', $json));
        }

        return new Money((string)$decoded['amount'], $decoded['currency']);
    }
}