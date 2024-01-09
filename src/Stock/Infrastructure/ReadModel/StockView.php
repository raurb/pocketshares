<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\ReadModel;

use Money\Currency;
use PocketShares\Stock\Domain\MarketSymbol;

readonly class StockView
{
    public function __construct(
        public int $id,
        public string $name,
        public string $ticker,
        public MarketSymbol $marketSymbol,
        public Currency $currency,
    ) {}
}