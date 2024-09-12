<?php

declare(strict_types=1);

namespace PocketShares\System\Domain;

use Money\Money;
use PocketShares\Shared\Domain\AggregateRoot;
use PocketShares\Stock\Domain\Stock;

class SystemDividendPayment extends AggregateRoot
{
    public function __construct(
        public readonly Stock              $stock,
        public readonly \DateTimeImmutable $recordDate,
        public readonly Money              $amount,
        public readonly ?int               $systemDividendId = null,
    )
    {
    }
}