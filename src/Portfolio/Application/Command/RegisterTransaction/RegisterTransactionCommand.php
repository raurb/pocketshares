<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Command\RegisterTransaction;

use PocketShares\Shared\Application\Command\CommandInterface;

readonly class RegisterTransactionCommand implements CommandInterface
{
    public function __construct(
        public int $portfolioId,
        public string $stockTicker,
        public string $transactionDate,
        public string $transactionType,
        public ?float $numberOfShares,
        public ?int $price,
        public ?string $priceCurrency,
    )
    {
    }
}