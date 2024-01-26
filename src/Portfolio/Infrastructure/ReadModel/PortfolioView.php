<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\ReadModel;

use Money\Money;

readonly class PortfolioView
{
    public function __construct(
        public int $id,
        public string $name,
        public Money $value,
    ) {
    }
}