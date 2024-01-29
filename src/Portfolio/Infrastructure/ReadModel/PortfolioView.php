<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\ReadModel;

readonly class PortfolioView
{
    public function __construct(
        public int    $id,
        public string $name,
        public int    $value,
        public string $valueCurrency,
    )
    {
    }
}