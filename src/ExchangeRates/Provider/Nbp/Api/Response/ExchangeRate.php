<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Provider\Nbp\Api\Response;

class ExchangeRate
{
    public function __construct(public readonly string $no, public readonly string $effectiveDate, public readonly float $mid)
    {
    }
}