<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Exception;

class CannotRegisterTransactionNoStock extends \RuntimeException
{
    public function __construct(string $stockTicker)
    {
        parent::__construct(sprintf('Cannot register transaction. Stock "%s" doesn\'t exist.', $stockTicker));
    }
}