<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Command\RegisterTransaction;

use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Shared\Application\Command\CommandInterface;
use PocketShares\Shared\Domain\NumberOfShares;

final class RegisterTransactionCommand implements CommandInterface
{
    private bool $lock = false;

    public function __construct(
        readonly public int $portfolioId,
        readonly public string $stockTicker,
        readonly public string $transactionDate,
        readonly public string $transactionType,
        readonly public int $price,
        readonly public ?float $numberOfShares,
        readonly public ?string $priceCurrency,
    )
    {
    }

    public static function create(
        int $portfolioId,
        string $stockTicker,
        \DateTime $transactionDate,
        TransactionType $transactionType,
        float $price,
        ?NumberOfShares $numberOfShares,
        ?string $priceCurrency,
    ): self
    {
        $command = new self(
            $portfolioId,
            $stockTicker,
            $transactionDate->format('Y-m-d H:i:s'),
            $transactionType->value,
            (int)($price * 100),
            $numberOfShares?->getNumberOfShares(),
            $priceCurrency ?? null,
        );

        $command->lock = true;

        return $command;
    }

    public function isLocked(): bool
    {
        return $this->lock;
    }
}