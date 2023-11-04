<?php

declare(strict_types=1);

namespace PocketShares\StockExchange\Stock;

use PocketShares\StockExchange\Symbol;

readonly class StockDto
{
    public function __construct(
        public string $name,
        public string $ticker,
        public Symbol $symbol,
        public ?int   $id = null,
    )
    {
    }
}