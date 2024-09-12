<?php

declare(strict_types=1);

namespace PocketShares\Tax\Infrastructure\ReadModel;

use Money\Currency;
use Money\Money;
use PocketShares\ExchangeRates\Domain\ExchangeRate;

readonly class DividendTaxDataView
{
    public function __construct(
        public int          $portfolioId,
        public int          $dividendId,
        public string       $stockTicker,
        public Money        $grossAmount,
        public float        $portfolioWithholdingTaxRate,
        public float        $portfolioIncomeTaxRate,
        public Currency     $incomeTaxCurrency,
        public ExchangeRate $exchangeRate,
        public ?float       $stockWithholdingTaxRate,
    )
    {
    }
}