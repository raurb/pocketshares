<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\ReadModel;

use PocketShares\Portfolio\Infrastructure\ReadModel\PortfolioDetails\PortfolioDetailsHoldingsView;

readonly class PortfolioDetailsView
{
    /**
     * @param int $id
     * @param string $name
     * @param int $value
     * @param string $valueCurrency
     * @param PortfolioDetailsHoldingsView[] $holdings
     */
    public function __construct(
        public int    $id,
        public string $name,
        public int    $value,
        public string $valueCurrency,
        public array $holdings,
    )
    {
    }
}