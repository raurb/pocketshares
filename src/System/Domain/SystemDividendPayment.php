<?php

declare(strict_types=1);

namespace PocketShares\System\Domain;

use Money\Money;
use PocketShares\Stock\Domain\Stock;

readonly class SystemDividendPayment
{
    public function __construct(public int                $systemDividendId,
                                public Stock              $stock,
                                public \DateTimeImmutable $recordDate,
                                public Money              $amount,
    ) {
    }
}