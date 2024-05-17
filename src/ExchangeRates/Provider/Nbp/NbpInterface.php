<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Provider\Nbp;

use Money\Currency;
use PocketShares\ExchangeRates\Provider\Nbp\Api\Response\ExchangeRatesResponse;

interface NbpInterface
{
    public function getMidExchangeRatesForCurrency(Currency $currency, ?\DateTimeImmutable $startDate = null, ?\DateTimeImmutable $endDate = null): ExchangeRatesResponse;
}