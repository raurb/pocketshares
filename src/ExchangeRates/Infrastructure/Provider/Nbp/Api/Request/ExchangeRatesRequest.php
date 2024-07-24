<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Api\Request;

use PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Exception\MaxDayIntervalExceeded;

readonly class ExchangeRatesRequest implements RequestInterface
{
    private const MAX_DAY_INTERVAL = 93;

    public function __construct(
        public string $currency,
        public ?\DateTimeImmutable $startDate,
        public ?\DateTimeImmutable $endDate,
    )
    {
        if ($this->startDate && $this->endDate) {
            $interval = $this->startDate->diff($this->endDate);

            if ($interval->days > self::MAX_DAY_INTERVAL) {
                throw new MaxDayIntervalExceeded(self::MAX_DAY_INTERVAL);
            }
        }
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