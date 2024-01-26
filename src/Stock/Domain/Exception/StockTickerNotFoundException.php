<?php

declare(strict_types=1);

namespace PocketShares\Stock\Domain\Exception;

class StockTickerNotFoundException extends \RuntimeException
{
    public function __construct(string $ticker)
    {
        parent::__construct(\sprintf('Stock with given ticker "%s" does not exist.', $ticker));
    }
}