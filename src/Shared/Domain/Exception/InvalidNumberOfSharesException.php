<?php

declare(strict_types=1);

namespace PocketShares\Shared\Domain\Exception;

use PocketShares\Shared\Domain\NumberOfShares;

class InvalidNumberOfSharesException extends \RuntimeException
{
    public function __construct(float $numberOfShares)
    {
        parent::__construct(\sprintf('Invalid number of shares provided: %d. The number precision should be %s', $numberOfShares, NumberOfShares::PRECISION));
    }
}