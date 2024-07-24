<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Exception;

class MaxDayIntervalExceeded extends \Exception
{
    public function __construct(int $maxInterval)
    {
        parent::__construct(\sprintf('Date range provided exceeds %d', $maxInterval));
    }
}