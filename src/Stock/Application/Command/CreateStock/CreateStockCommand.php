<?php

declare(strict_types=1);

namespace PocketShares\Stock\Application\Command\CreateStock;

use PocketShares\Shared\Application\Command\CommandInterface;

readonly class CreateStockCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $ticker,
        public string $marketSymbol,
        public string $currency,
    ) {}
}