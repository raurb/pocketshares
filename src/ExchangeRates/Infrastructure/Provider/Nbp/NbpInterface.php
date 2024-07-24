<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Infrastructure\Provider\Nbp;

use Money\Currency;

interface NbpInterface
{
    public function getMidExchangeRatesForCurrency(Currency $currency, ?\DateTimeImmutable $startDate = null, ?\DateTimeImmutable $endDate = null): array;
}