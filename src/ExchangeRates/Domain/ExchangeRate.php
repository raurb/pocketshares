<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Domain;

use Money\Currency;

readonly class ExchangeRate
{
    public function __construct(
        public Currency           $currencyFrom,
        public Currency           $currencyTo,
        public \DateTimeImmutable $date,
        public float              $rate,
        public ?int $id = null,
    )
    {
    }
}