<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\ReadModel;

readonly class StockView
{
    public function __construct(
        public int $id,
        public string $name,
        public string $ticker,
        public string $marketSymbol,
        public string $currency,
    ) {}
}