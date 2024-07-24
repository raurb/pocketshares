<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Domain;

use Money\Currency;

class ExchangeRate
{
    public function __construct(
        public readonly Currency $fromCurrency,
        public readonly Currency $toCurrency,
        public readonly \DateTimeImmutable $date,
        public readonly float $value
    ) {
    }
}