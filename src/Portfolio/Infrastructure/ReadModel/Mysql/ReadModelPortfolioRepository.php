<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\ReadModel\Mysql;

use PocketShares\Portfolio\Domain\Repository\PortfolioReadModelInterface;
use PocketShares\Portfolio\Infrastructure\ReadModel\PortfolioDetails\PortfolioDetailsHoldingsView;
use PocketShares\Portfolio\Infrastructure\ReadModel\PortfolioDetailsView;
use PocketShares\Portfolio\Infrastructure\ReadModel\PortfolioDividendView;
use PocketShares\Portfolio\Infrastructure\ReadModel\PortfolioView;
use PocketShares\Portfolio\Infrastructure\ReadModel\TransactionView;
use PocketShares\Shared\Infrastructure\Persistence\ReadModel\Repository\MysqlRepository;

class ReadModelPortfolioRepository extends MysqlRepository implements PortfolioReadModelInterface
{
    /** @return PortfolioView[] */
    public function getAllPortfolios(): array
    {
        $sql = "SELECT 
                id, 
                name, 
                value ->> '$.amount'   AS portfolio_value_amount,
                value ->> '$.currency' AS portfolio_value_currency
            FROM portfolio;";

        $results = $this->executeRawQuery($sql)->fetchAllAssociative();

        if (!$results) {
            return [];
        }

        $portfolios = [];

        foreach ($results as $dbPortfolio) {
            $portfolios[] = new PortfolioView(
                id: $dbPortfolio['id'],
                name: $dbPortfolio['name'],
                value: (int)$dbPortfolio['portfolio_value_amount'],
                valueCurrency: $dbPortfolio['portfolio_value_currency'],
            );
        }

        return $portfolios;
    }

    public function getPortfolioDetails(int $portfolioId): ?PortfolioDetailsView
    {
        $sql = "SELECT
                   p.name AS portfolio_name,
                   p.value ->> '$.amount'   AS portfolio_value_amount,
                   p.value ->> '$.currency' AS portfolio_value_currency,
                   ph. id AS holding_id,
                   ph.stock_id,
                   ph.number_of_shares AS holding_number_of_shares,
                   s.name AS stock_name,
                   s.ticker AS stock_ticker,
                   s.market_symbol AS stock_market_symbol,
                   s.currency AS stock_currency
            FROM portfolio p
                     LEFT JOIN pocketshares.portfolio_holding ph on p.id = ph.portfolio_id
                     LEFT JOIN pocketshares.stock s on s.id = ph.stock_id
            WHERE p.id = :portfolioId;";

        $result = $this->executeRawQuery($sql, ['portfolioId' => $portfolioId])->fetchAllAssociative();

        $hasDividends = $this->executeRawQuery('SELECT COUNT(*) as cnt FROM portfolio_dividend_payment WHERE portfolio_id = :portfolioId', ['portfolioId' => $portfolioId])->fetchAllAssociative();

        if (!$result) {
            return null;
        }

        $portfolioName = '';
        $portfolioValueAmount = '';
        $portfolioValueCurrency = '';
        $holdings = [];

        foreach ($result as $item) {
            $portfolioName = $item['portfolio_name'];
            $portfolioValueAmount = $item['portfolio_value_amount'];
            $portfolioValueCurrency = $item['portfolio_value_currency'];

            if (!$item['holding_id']) {
                continue;
            }

            $holdings[] = new PortfolioDetailsHoldingsView(
                holdingId: $item['holding_id'],
                stockId: $item['stock_id'],
                stockName: $item['stock_name'],
                stockTicker: $item['stock_ticker'],
                stockMarketSymbol: $item['stock_market_symbol'],
                numberOfShares: (float)$item['holding_number_of_shares'],
                currency: $item['stock_currency'],
            );
        }

        return new PortfolioDetailsView(
            id: $portfolioId,
            name: $portfolioName,
            value: (int)$portfolioValueAmount,
            valueCurrency: $portfolioValueCurrency,
            holdings: $holdings,
            hasDividends: $hasDividends && $hasDividends[0]['cnt'],
        );

    }

    public function getPortfolioTransactions(int $portfolioId): array
    {
        $sql = "SELECT 
            id, 
            stock_ticker, 
            number_of_shares,                    
            value ->> '$.amount' AS transaction_value_amount,
            value ->> '$.currency' AS transaction_value_currency,
            transaction_date,
            transaction_type
            FROM portfolio_transaction WHERE portfolio_id = :portfolioId";

        $result = $this->executeRawQuery($sql, ['portfolioId' => $portfolioId])->fetchAllAssociative();

        if (!$result) {
            return [];
        }

        $transactions = [];

        foreach ($result as $item) {
            $transactions[] = new TransactionView(
                transactionId: $item['id'],
                stockTicker: $item['stock_ticker'],
                numberOfShares: (float)$item['number_of_shares'],
                transactionValue: (int)$item['transaction_value_amount'],
                transactionCurrency: $item['transaction_value_currency'],
                transactionDate: $item['transaction_date'],
                transactionType: $item['transaction_type'],
            );
        }

        return $transactions;
    }

    public function getPortfolioDividends(int $portfolioId, ?\DateTimeImmutable $from = null, ?\DateTimeImmutable $to = null): array
    {
        $sql = "SELECT
                dp.id,
                s.ticker,
                dp.record_date,
                dp.amount ->> '$.amount' / 100  AS dividend_amount,
                dp.amount ->> '$.currency' AS dividend_currency
                FROM dividend_payment dp
                LEFT JOIN stock s ON s.id = dp.stock_id
                WHERE dp.id IN (SELECT dividend_id FROM portfolio_dividend_payment WHERE portfolio_id = :portfolioId);
                ";

        $results = $this->executeRawQuery($sql, ['portfolioId' => $portfolioId])->fetchAllAssociative();

        if (!$results) {
            return [];
        }

        $portfolioDividends = [];

        foreach ($results as $dividend) {
            $portfolioDividends[] = new PortfolioDividendView(
                id: $dividend['id'],
                stockTicker: $dividend['ticker'],
                payoutDate: \DateTimeImmutable::createFromFormat('Y-m-d', $dividend['record_date']),
                amount: (int)($dividend['dividend_amount'] * 100),
                amountCurrency: $dividend['dividend_currency'],
            );
        }

        return $portfolioDividends;
    }
}