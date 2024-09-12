<?php

declare(strict_types=1);

namespace PocketShares\Tax\Domain;

use Money\Currency;
use Money\Money;
use PocketShares\ExchangeRates\Domain\ExchangeRate;
use PocketShares\Shared\Domain\AggregateRoot;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Shared\Utilities\MoneyParser;
use PocketShares\Tax\Domain\Exception\IncomeTaxRateTestException;

class DividendTax extends AggregateRoot
{
    public readonly DividendIncomeTax $calculatedIncomeTax;

    public Money $withholdingTaxAmount;
    public float $withholdingTaxRate;

    public function __construct(
        public readonly int          $portfolioId,
        public readonly int          $dividendId,
        public readonly string       $stockTicker,
        public readonly Money        $dividendGrossAmount,
        public readonly Currency     $incomeTaxCurrency,
        public readonly float        $portfolioWithholdingTaxRate,
        public readonly float        $incomeTaxRate,
        public readonly ExchangeRate $exchangeRate,
        public ?float                $stockWithholdingTaxRate,
    )
    {
        $this->withholdingTaxRate = $this->stockWithholdingTaxRate ?: $this->portfolioWithholdingTaxRate;
        $this->withholdingTaxAmount = $this->calculateWithholdingTaxAmount();
        $this->calculatedIncomeTax = $this->calculateIncomeTaxAmount();
    }

    private function calculateWithholdingTaxAmount(): Money
    {
        return $this->dividendGrossAmount->multiply(MoneyParser::floatToInt($this->withholdingTaxRate), Money::ROUND_HALF_UP)->roundToUnit(2)->divide(100);
    }

    private function calculateIncomeTaxAmount(): DividendIncomeTax
    {
        $dividendAmountInTargetCurrencyGross = round(($this->dividendGrossAmount->getAmount() / 100) * $this->exchangeRate->rate, 2);
        $dividendWithholdingTaxInTargetCurrency = round(($this->withholdingTaxAmount->getAmount() / 100) * $this->exchangeRate->rate, 2);
        $taxToPayInTargetCurrency = round($dividendAmountInTargetCurrencyGross * $this->incomeTaxRate, 2);
        $taxLeftToPayInTargetCurrency = $taxToPayInTargetCurrency - $dividendWithholdingTaxInTargetCurrency;
        $dividendAmountInTargetCurrencyNet = $dividendAmountInTargetCurrencyGross - $dividendWithholdingTaxInTargetCurrency - $taxLeftToPayInTargetCurrency;
        $incomeTaxRateTest = round(1 - ($dividendAmountInTargetCurrencyNet / $dividendAmountInTargetCurrencyGross), 2);

        if ($incomeTaxRateTest !== $this->incomeTaxRate) {
            throw new IncomeTaxRateTestException(
                portfolioId: $this->portfolioId,
                dividendId: $this->dividendId,
                incomeTaxCurrency: $this->incomeTaxCurrency->getCode(),
                dividendAmountInTargetCurrencyGross: $dividendAmountInTargetCurrencyGross,
                dividendWithholdingTaxInTargetCurrency: $dividendWithholdingTaxInTargetCurrency,
                taxToPayInTargetCurrency: $taxToPayInTargetCurrency,
                taxLeftToPayInTargetCurrency: $taxLeftToPayInTargetCurrency,
                dividendAmountInTargetCurrencyNet: $dividendAmountInTargetCurrencyNet,
                incomeTaxRate: $this->incomeTaxRate,
                incomeTaxRateTest: $incomeTaxRateTest,
            );
        }


        return new DividendIncomeTax(
            dividendAmountInTargetCurrencyGross: MoneyFactory::create(MoneyParser::floatToInt($dividendAmountInTargetCurrencyGross), $this->incomeTaxCurrency->getCode()),
            dividendWithholdingTaxInTargetCurrency: MoneyFactory::create(MoneyParser::floatToInt($dividendWithholdingTaxInTargetCurrency), $this->incomeTaxCurrency->getCode()),
            taxToPayInTargetCurrency: MoneyFactory::create(MoneyParser::floatToInt($taxToPayInTargetCurrency), $this->incomeTaxCurrency->getCode()),
            taxLeftToPayInTargetCurrency: MoneyFactory::create(MoneyParser::floatToInt($taxLeftToPayInTargetCurrency), $this->incomeTaxCurrency->getCode()),
            dividendAmountInTargetCurrencyNet: MoneyFactory::create(MoneyParser::floatToInt($dividendAmountInTargetCurrencyNet), $this->incomeTaxCurrency->getCode()),
        );
    }
}