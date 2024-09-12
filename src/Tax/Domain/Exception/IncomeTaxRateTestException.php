<?php

declare(strict_types=1);

namespace PocketShares\Tax\Domain\Exception;

class IncomeTaxRateTestException extends \Exception
{
    public function __construct(
        int    $portfolioId,
        int    $dividendId,
        string $incomeTaxCurrency,
        float  $dividendAmountInTargetCurrencyGross,
        float  $dividendWithholdingTaxInTargetCurrency,
        float  $taxToPayInTargetCurrency,
        float  $taxLeftToPayInTargetCurrency,
        float  $dividendAmountInTargetCurrencyNet,
        float  $incomeTaxRate,
        float  $incomeTaxRateTest,
    )
    {
        $parameters = [
            'portfolioId' => $portfolioId,
            'dividendId' => $dividendId,
            'incomeTaxCurrency' => $incomeTaxCurrency,
            'dividendAmountInTargetCurrencyGross' => $dividendAmountInTargetCurrencyGross,
            'dividendWithholdingTaxInTargetCurrency' => $dividendWithholdingTaxInTargetCurrency,
            'taxToPayInTargetCurrency' => $taxToPayInTargetCurrency,
            'taxLeftToPayInTargetCurrency' => $taxLeftToPayInTargetCurrency,
            'dividendAmountInTargetCurrencyNet' => $dividendAmountInTargetCurrencyNet,
            'incomeTaxRate' => $incomeTaxRate,
            'incomeTaxRateTest' => $incomeTaxRateTest,
        ];

        parent::__construct(\sprintf('Calculating dividend income tax did not pass income tax rate test. Parameters: %s', \json_encode($parameters, JSON_THROW_ON_ERROR)));
    }
}