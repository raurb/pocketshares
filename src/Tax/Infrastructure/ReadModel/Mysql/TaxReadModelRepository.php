<?php

namespace PocketShares\Tax\Infrastructure\ReadModel\Mysql;

use Money\Currency;
use PocketShares\ExchangeRates\Domain\ExchangeRate;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Infrastructure\Persistence\ReadModel\Repository\MysqlRepository;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Tax\Domain\Repository\TaxReadModelInterface;
use PocketShares\Tax\Infrastructure\ReadModel\DividendTaxDataView;
use PocketShares\Tax\Infrastructure\ReadModel\PortfolioDividendIncomeTaxView;

class TaxReadModelRepository extends MysqlRepository implements TaxReadModelInterface
{
    public function getDividendTaxData(int $portfolioId, int $dividendId): ?DividendTaxDataView
    {
        //@todo income_tax_rate (float) i income_tax_currency (string - Currency) przerobic na ustawienia konta
        $dividendDataSql = 'SELECT sdp.amount AS dividend_amount,
                       sdp.payout_date,
                       0.15       as portfolio_withholding_tax_rate,
                       0.15       as stock_withholding_tax_rate,
                       0.19       as income_tax_rate,
                       "PLN" as income_tax_currency,
                       s.ticker
                FROM portfolio_dividend_payment pdp
                         LEFT JOIN system_dividend_payment sdp on pdp.dividend_id = sdp.id
                        LEFT JOIN stock s ON s.id = sdp.stock_id
                WHERE pdp.portfolio_id = :portfolioId
                  AND pdp.dividend_id = :dividendId';

        $dividendData = $this->connection->executeQuery($dividendDataSql, ['portfolioId' => $portfolioId, 'dividendId' => $dividendId])->fetchAssociative();

        if (!$dividendData) {
            return null;
        }

        $dividendAmount = MoneyFactory::fromJson($dividendData['dividend_amount']);

        $exchangeRateSql = 'SELECT *
                             from exchange_rate
                             WHERE date < :payoutDate
                                AND currency_from = :currencyFrom
                                AND currency_to = :currencyTo
                             order by date DESC
                             limit 1';

        $exchangeRateData = $this->connection->executeQuery($exchangeRateSql, [
            'payoutDate' => $dividendData['payout_date'],
            'currencyFrom' => $dividendAmount->getCurrency()->getCode(),
            'currencyTo' => $dividendData['income_tax_currency'],
        ])->fetchAssociative();

        if (!$exchangeRateData) {
            throw new \RuntimeException('No exchange rate for given dividend ' . $dividendId);
        }

        return new DividendTaxDataView(
            portfolioId: $portfolioId,
            dividendId: $dividendId,
            stockTicker: $dividendData['ticker'],
            grossAmount: $dividendAmount,
            portfolioWithholdingTaxRate: $dividendData['portfolio_withholding_tax_rate'],
            portfolioIncomeTaxRate: $dividendData['income_tax_rate'],
            incomeTaxCurrency: new Currency($dividendData['income_tax_currency']),
            exchangeRate: new ExchangeRate(
                currencyFrom: new Currency($exchangeRateData['currency_from']),
                currencyTo: new Currency($exchangeRateData['currency_to']),
                date: \DateTimeImmutable::createFromFormat('Y-m-d', $exchangeRateData['date']),
                rate: (float)$exchangeRateData['rate'],
                id: (int)$exchangeRateData['id'],
            ),
            stockWithholdingTaxRate: $dividendData['stock_withholding_tax_rate'] ?? null,
        );
    }

    public function getPortfolioDividendIncomeTaxes(int $portfolioId): ?array
    {
        $sql = 'SELECT pdit.*, sdp.*, er.rate, er.date as exchange_rate_date, er.currency_to as exchange_rate_currency
                FROM portfolio_dividend_income_tax pdit 
                LEFT JOIN system_dividend_payment sdp ON sdp.id = pdit.system_dividend_id 
                LEFT JOIN exchange_rate er ON er.id = pdit.exchange_rate_id
                WHERE pdit.portfolio_id = :portfolioId;';

        $taxes = $this->connection->executeQuery($sql, ['portfolioId' => $portfolioId])->fetchAllAssociative();

        if (!$taxes) {
            return null;
        }

        $taxesViews = [];

        foreach ($taxes as $tax) {
            $dividend = MoneyFactory::fromJson($tax['amount']);
            $withholdingTax = MoneyFactory::fromJson($tax['withholding_tax_amount']);
            $dividendAmountInTargetCurrencyGross = MoneyFactory::fromJson($tax['dividend_amount_in_target_currency_gross']);
            $dividendAmountInTargetCurrencyNet = MoneyFactory::fromJson($tax['dividend_amount_in_target_currency_net']);
            $dividendGrossAmount = MoneyFactory::fromJson($tax['dividend_gross_amount']);
            $dividendWithholdingTaxInTargetCurrency = MoneyFactory::fromJson($tax['dividend_withholding_tax_in_target_currency']);
            $taxLeftToPayInTargetCurrency = MoneyFactory::fromJson($tax['tax_left_to_pay_in_target_currency']);
            $taxToPayInTargetCurrency = MoneyFactory::fromJson($tax['tax_to_pay_in_target_currency']);

            $taxesViews[] = new PortfolioDividendIncomeTaxView(
                portfolioId: $portfolioId,
                dividendPayoutDate: \DateTimeImmutable::createFromFormat('Y-m-d', $tax['payout_date']),
                stockTicker: $tax['stock_ticker'],
                dividendCurrency: $dividend->getCurrency(),
                dividendAmount: $dividend->getAmount(),
                withholdingTax: $withholdingTax->getAmount(),
                withholdingTaxRate: (float)$tax['withholding_tax_rate'],
                exchangeRateDate: \DateTimeImmutable::createFromFormat('Y-m-d', $tax['exchange_rate_date']),
                exchangeRate: (float)$tax['rate'],
                exchangeRateCurrency: $tax['exchange_rate_currency'],
                dividendAmountInTargetCurrency: (float)$dividendAmountInTargetCurrencyGross->getAmount(),
                dividendWithholdingTaxInTargetCurrency: (float)$dividendWithholdingTaxInTargetCurrency->getAmount(),
                taxToPayInTargetCurrency: (float)$taxToPayInTargetCurrency->getAmount(),
                taxLeftToPayInTargetCurrency: (float)$taxLeftToPayInTargetCurrency->getAmount(),
                dividendNetAmountInTargetCurrency: (float)$dividendAmountInTargetCurrencyNet->getAmount(),
            );
        }

        return $taxesViews;
    }
}