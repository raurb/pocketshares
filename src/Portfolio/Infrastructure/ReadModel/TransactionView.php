<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\ReadModel;

readonly class TransactionView
{
    public function __construct(
        public int $transactionId,
        public string $stockTicker,
        public float $numberOfShares,
        public int $transactionValue,
        public string $transactionCurrency,
        public string $transactionDate,
        public string $transactionType,
    )
    {
    }
}