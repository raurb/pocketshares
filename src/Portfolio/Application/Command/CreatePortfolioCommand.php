<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Command;

use PocketShares\Shared\Application\Command\CommandInterface;

readonly class CreatePortfolioCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $currencyCode,
    ) {
    }
}