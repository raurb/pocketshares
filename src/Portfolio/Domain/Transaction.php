<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain;

use Money\Money;
use PocketShares\Portfolio\Domain\Exception\BuySellTransactionNoNumberOfSharesException;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Stock\Domain\Stock;

readonly class Transaction
{
    public const string TRANSACTION_DATE_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        public Stock              $stock,
        public \DateTimeImmutable $transactionDate,
        public TransactionType    $transactionType,
        public Money              $pricePerShare,
        public ?NumberOfShares    $numberOfShares = null,
    )
    {
        if (\in_array($transactionType, [TransactionType::TYPE_BUY, TransactionType::TYPE_SELL], true)) {
            $this->validateNumberOfShares($numberOfShares);
        }
    }

    private function validateNumberOfShares(?NumberOfShares $numberOfShares): void
    {
        if (!$numberOfShares || $numberOfShares->isZero()) {
            throw new BuySellTransactionNoNumberOfSharesException($this->transactionType, $this->numberOfShares);
        }
    }
}