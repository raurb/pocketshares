<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Exception;

class CannotRegisterTransactionNoHolding extends \RuntimeException
{
    public function __construct(string $stockTicker)
    {
        parent::__construct(sprintf('Cannot register transaction. Holding "%s" doesn\'t exist in portfolio.', $stockTicker));
    }
}