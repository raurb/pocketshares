<?php

declare(strict_types=1);

namespace PocketShares\Stock\Domain;

use Money\Money;

readonly class DividendPayment
{
    public function __construct(
        public Stock $stock,
        public \DateTimeImmutable $recordDate,
        public Money $amount,
    ) {
    }
}