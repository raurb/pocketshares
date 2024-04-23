<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain;

use PocketShares\Portfolio\Domain\Exception\CannotSellMoreStocksThanOwnException;
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
            TransactionType::TYPE_BUY => $numberOfShares = $this->numberOfShares->getNumberOfShares() + $transaction->numberOfShares->getNumberOfShares(),
            TransactionType::TYPE_SELL => $numberOfShares = $this->numberOfShares->getNumberOfShares() - $transaction->numberOfShares->getNumberOfShares(),
            TransactionType::TYPE_CLOSE_POSITION => $numberOfShares = 0,
        };

        if ($numberOfShares < 0) {
            throw new CannotSellMoreStocksThanOwnException(
                $this->stock->ticker,
                $this->numberOfShares->getNumberOfShares(),
                $transaction->numberOfShares->getNumberOfShares()
            );
        }

        $this->numberOfShares = new NumberOfShares($numberOfShares);
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