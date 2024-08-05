<?php

declare(strict_types=1);

namespace PocketShares\Tax\Domain;

use Money\Money;

readonly class Tax
{
    public function __construct(
        public Money $amount,
    )
    {
    }
}