<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain;

use Money\Money;
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
        public ?NumberOfShares    $numberOfShares,
    )
    {
    }
}