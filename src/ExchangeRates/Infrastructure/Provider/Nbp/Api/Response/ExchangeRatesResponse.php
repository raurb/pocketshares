<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Api\Response;

class ExchangeRatesResponse
{
    private string $table;
    private string $currency;
    private string $code;

    /** @var ExchangeRate[] */
    private array $rates = [];

    public function __construct(array $response)
    {
        $this->table = $response['table'];
        $this->currency = $response['currency'];
        $this->code = $response['code'];

        foreach ($response['rates'] ?? [] as $rate) {
            $this->rates[] = new ExchangeRate($rate['no'], $rate['effectiveDate'], $rate['mid']);
        }
    }

    public function getRates(): array
    {
        return $this->rates;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}