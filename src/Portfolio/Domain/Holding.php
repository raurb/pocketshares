<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain;

use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Stock\Domain\Stock;

class Holding
{
    /**
     * @param Stock $stock
     * @param NumberOfShares $numberOfShares
     * @param Transaction[] $transactionHistory
     */
    public function __construct(
        private readonly Stock $stock,
        private NumberOfShares $numberOfShares,
        private array          $transactionHistory = [],
    )
    {
    }

    public function registerTransaction(Transaction $transaction): void
    {
        match ($transaction->transactionType) {
            TransactionType::TYPE_BUY => $this->numberOfShares = new NumberOfShares($this->numberOfShares->getNumberOfShares() + $transaction->numberOfShares->getNumberOfShares()),
            TransactionType::TYPE_SELL => $this->numberOfShares = new NumberOfShares($this->numberOfShares->getNumberOfShares() - $transaction->numberOfShares->getNumberOfShares()),
            TransactionType::TYPE_CLOSE_POSITION => $this->numberOfShares = new NumberOfShares(0),
        };

        $this->transactionHistory[] = $transaction;
    }

    public function getStock(): Stock
    {
        return $this->stock;
    }

    public function getNumberOfShares(): NumberOfShares
    {
        return $this->numberOfShares;
    }

    public function getTransactionHistory(): array
    {
        return $this->transactionHistory;
    }
}