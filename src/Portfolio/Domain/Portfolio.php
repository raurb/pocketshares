<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use PocketShares\Shared\Domain\AggregateRoot;
use PocketShares\Stock\Domain\Exception\UnknownCurrencyException;

class Portfolio extends AggregateRoot
{
    public function __construct(
        public readonly string $name,
        public readonly Money $value,
        public readonly array $holdings,
    ) {
    }

    public static function create(
        string $name,
        string $currencyCode,
    ): self
    {
        $currency = new Currency($currencyCode);
        if (!(new ISOCurrencies())->contains($currency)) {
            throw new UnknownCurrencyException($currency->getCode());
        }

        return new self($name, new Money(0, $currency), []);
    }
}