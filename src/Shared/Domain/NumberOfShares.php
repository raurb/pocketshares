<?php

declare(strict_types=1);

namespace PocketShares\Shared\Domain;

use PocketShares\Shared\Domain\Exception\InvalidNumberOfSharesException;

class NumberOfShares
{
    public const PRECISION = 4;

    private float $numberOfShares;

    public function __construct(float $numberOfShares = 0.0)
    {
        $this->validateShares($numberOfShares);
        $this->numberOfShares = $numberOfShares;
    }

    public function getNumberOfShares(): float
    {
        return $this->numberOfShares;
    }

    private function validateShares(float $numberOfShares): void
    {
        $exploded = explode('.', (string)$numberOfShares);

        if (isset ($exploded[1]) && strlen($exploded[1]) > self::PRECISION) {
            throw new InvalidNumberOfSharesException($numberOfShares);
        }
    }
}