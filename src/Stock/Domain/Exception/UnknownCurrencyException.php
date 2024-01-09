<?php

declare(strict_types=1);

namespace PocketShares\Stock\Domain\Exception;

class UnknownCurrencyException extends \Exception
{
    public function __construct(string $currency)
    {
        parent::__construct(sprintf('Cannot find ISO currency %s', $currency));
    }
}