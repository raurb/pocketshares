<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Infrastructure\Provider\Nbp;

use Money\Currency;
use PocketShares\ExchangeRates\Domain\ExchangeRate;
use PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Api\ApiClient;
use PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Api\Request\ExchangeRatesRequest;

class Nbp implements NbpInterface
{
    public function __construct(private readonly ApiClient $apiClient)
    {
    }

    public function getMidExchangeRatesForCurrency(Currency $currency, ?\DateTimeImmutable $startDate = null, ?\DateTimeImmutable $endDate = null): array
    {
        $response = $this->apiClient->getMidExchangeRatesForCurrency(new ExchangeRatesRequest($currency->getCode(), $startDate, $endDate));
        $exchangeRates = [];

        foreach ($response->getRates() as $rate) {
            $exchangeRates[] = new ExchangeRate(
                $currency,
                new Currency('PLN'),
                \DateTimeImmutable::createFromFormat('Y-m-d', $rate->effectiveDate),
                $rate->mid,
            );
        }

        return $exchangeRates;
    }
}