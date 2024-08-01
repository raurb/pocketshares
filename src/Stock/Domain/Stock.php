<?php

declare(strict_types=1);

namespace PocketShares\Stock\Domain;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use PocketShares\Shared\Domain\AggregateRoot;
use PocketShares\Stock\Domain\Exception\UnknownCurrencyException;

class Stock extends AggregateRoot
{
    public function __construct(
        public readonly string $ticker,
        public readonly string $name,
        public readonly MarketSymbol $marketSymbol,
        public readonly Currency $currency,
        public readonly ?int $id = null,
    ) {}

    public static function create(string $ticker, string $name, MarketSymbol $marketSymbol, Currency $currency): self
    {
        $isoCurrencies = new ISOCurrencies();
        if (!$isoCurrencies->contains($currency)) {
            throw new UnknownCurrencyException($currency->getCode());
        }

        return new self($ticker, $name, $marketSymbol, $currency);
    }
}