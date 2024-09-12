<?php

declare(strict_types=1);

namespace PocketShares\Tax\Domain;

use Money\Money;

readonly class DividendIncomeTax
{
    public function __construct(
        public Money $dividendAmountInTargetCurrencyGross,
        public Money $dividendWithholdingTaxInTargetCurrency,
        public Money $taxToPayInTargetCurrency,
        public Money $taxLeftToPayInTargetCurrency,
        public Money $dividendAmountInTargetCurrencyNet
    )
    {
    }
}