<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain;

use Money\Money;
use PocketShares\Portfolio\Domain\Exception\InvalidTransactionDate;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Stock\Domain\Stock;

readonly class Transaction
{
    public const TRANSACTION_DATE_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        public Stock              $stock,
        public \DateTimeImmutable $transactionDate,
        public TransactionType    $transactionType,
        public Money             $price,
        public ?NumberOfShares    $numberOfShares,
    )
    {
    }

    public static function createTransactionDateFromString(string $date): \DateTimeImmutable
    {
        $dateTime = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $date);

        if (!$dateTime) {
            throw new InvalidTransactionDate($date);
        }

        return $dateTime;
    }
}