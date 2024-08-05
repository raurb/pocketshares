<?php

declare(strict_types=1);

namespace PocketShares\Tax\Domain;

use Money\Money;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Stock\Domain\Stock;

readonly class DividendTax
{
    public function __construct(
        public Stock              $stock,
        public \DateTimeImmutable $payoutDate,
        public NumberOfShares     $numberOfShares,
        public Money              $grossAmount,
        public Money              $fee,
        public Tax                $withholdingTax,
        public Tax                $incomeTax,
    )
    {
    }

    public static function create(): self
    {

    }
}