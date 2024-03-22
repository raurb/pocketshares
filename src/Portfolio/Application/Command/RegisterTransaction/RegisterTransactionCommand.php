<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Command\RegisterTransaction;

use PocketShares\Shared\Application\Command\CommandInterface;

final class RegisterTransactionCommand implements CommandInterface
{
    public function __construct(
        readonly public int                $portfolioId,
        readonly public string             $stockTicker,
        readonly public \DateTimeImmutable $transactionDate,
        readonly public string             $transactionType,
        readonly public int                $price,
        readonly public ?float             $numberOfShares,
        readonly public ?string            $priceCurrency,
    )
    {
    }
}