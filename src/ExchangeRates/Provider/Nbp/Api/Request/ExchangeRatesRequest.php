<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Provider\Nbp\Api\Request;

use Money\Currency;

readonly class ExchangeRatesRequest implements RequestInterface
{
    public function __construct(
        public string $currency,
        public ?\DateTimeImmutable $startDate,
        public ?\DateTimeImmutable $endDate,
    )
    {
    }

    public function getPath(): string
    {
        return \sprintf(
            'exchangerates/rates/a/%s%s%s',
            $this->currency,
            $this->startDate ? '/' . $this->startDate->format('Y-m-d') : '',
            $this->endDate ? '/' . $this->endDate->format('Y-m-d') : '',
        );
    }

    public function getQueryParameters(): array
    {
        return [];
    }

    public function getPayload(): array
    {
        return [];
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function getMethod(): string
    {
        return 'GET';
    }
}