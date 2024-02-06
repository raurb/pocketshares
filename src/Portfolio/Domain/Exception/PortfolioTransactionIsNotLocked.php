<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Exception;

class PortfolioTransactionIsNotLocked extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Transaction is not locked.');
    }
}