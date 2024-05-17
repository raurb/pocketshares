<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Provider\Nbp;

use Money\Currency;
use PocketShares\ExchangeRates\Provider\Nbp\Api\ApiClient;
use PocketShares\ExchangeRates\Provider\Nbp\Api\Request\ExchangeRatesRequest;
use PocketShares\ExchangeRates\Provider\Nbp\Api\Response\ExchangeRatesResponse;

class Nbp implements NbpInterface
{
    public function __construct(private readonly ApiClient $apiClient)
    {
    }

    public function getMidExchangeRatesForCurrency(Currency $currency, ?\DateTimeImmutable $startDate = null, ?\DateTimeImmutable $endDate = null): ExchangeRatesResponse
    {
        return $this->apiClient->getMidExchangeRatesForCurrency(new ExchangeRatesRequest($currency->getCode(), $startDate, $endDate));
    }
}