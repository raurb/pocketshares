<?php

declare(strict_types=1);

namespace PocketShares\Tax\Infrastructure\ReadModel;

readonly class PortfolioDividendIncomeTaxView
{
    public function __construct(
        public int $portfolioId,
        public \DateTimeImmutable $dividendPayoutDate,
        public string $stockTicker,
        public string $dividendCurrency,
        public float $dividendAmount,
        public float $withholdingTax,
        public float $withholdingTaxRate,
        public \DateTimeImmutable $exchangeRateDate,
        public float $exchangeRate,
        public string $exchangeRateCurrency,
        public float $dividendAmountInTargetCurrency,
        public float $dividendWithholdingTaxInTargetCurrency,
        public float $taxToPayInTargetCurrency,
        public float $taxLeftToPayInTargetCurrency,
        public float $dividendNetAmountInTargetCurrency,
    )
    {
    }
}