<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Exception;

class CannotSellMoreStocksThanOwnException extends \RuntimeException
{
    public function __construct(string $stockTicker, float $sharesOwn, float $sellAmount)
    {
        parent::__construct(\sprintf('Cannot sell more shares of stock "%s" than already own. Shares own: %d, sell amount: %d', $stockTicker, $sharesOwn, $sellAmount));
    }
}