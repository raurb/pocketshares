<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\ReadModel\PortfolioDetails;

readonly class PortfolioDetailsHoldingsView
{
    public function __construct(
        public int    $holdingId,
        public int    $stockId,
        public string $stockName,
        public string $stockTicker,
        public string $stockMarketSymbol,
        public float  $numberOfShares,
        public string $currency,
    )
    {
    }
}