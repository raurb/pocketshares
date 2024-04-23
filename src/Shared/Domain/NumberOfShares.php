<?php

declare(strict_types=1);

namespace PocketShares\Shared\Domain;

use PocketShares\Portfolio\Domain\Exception\NegativeNumberOfSharesException;
use PocketShares\Shared\Domain\Exception\InvalidNumberOfSharesException;

class NumberOfShares
{
    public const PRECISION = 4;

    private float $numberOfShares;

    public function __construct(float $numberOfShares)
    {
        $this->validateShares($numberOfShares);
        $this->numberOfShares = $numberOfShares;
    }

    public function getNumberOfShares(): float
    {
        return $this->numberOfShares;
    }

    public function isZero(): bool
    {
        return $this->numberOfShares === 0.0;
    }

    private function validateShares(float $numberOfShares): void
    {
        if ($numberOfShares < 0) {
            throw new NegativeNumberOfSharesException($numberOfShares);
        }

        $exploded = explode('.', (string)$numberOfShares);

        if (isset ($exploded[1]) && strlen($exploded[1]) > self::PRECISION) {
            throw new InvalidNumberOfSharesException($numberOfShares);
        }
    }
}