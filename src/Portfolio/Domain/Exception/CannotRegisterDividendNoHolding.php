<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Exception;

class CannotRegisterDividendNoHolding extends \RuntimeException
{
    public function __construct(string $stockTicker)
    {
        parent::__construct(sprintf('Cannot register dividend payment. Holding "%s" doesn\'t exist in portfolio.', $stockTicker));
    }
}