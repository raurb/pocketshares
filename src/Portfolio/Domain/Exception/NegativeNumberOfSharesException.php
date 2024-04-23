<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Exception;

class NegativeNumberOfSharesException extends \Exception
{
    public function __construct(float $numberOfShares)
    {
        parent::__construct(\sprintf(
            'Number of shares cannot be zero or a negative number. Provided value: "%d"',
            $numberOfShares,
        ));
    }
}