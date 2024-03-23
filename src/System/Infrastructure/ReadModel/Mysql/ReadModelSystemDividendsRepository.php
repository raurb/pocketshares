<?php

declare(strict_types=1);

namespace PocketShares\System\Infrastructure\ReadModel\Mysql;

use PocketShares\Shared\Infrastructure\Persistence\ReadModel\Repository\MysqlRepository;
use PocketShares\System\Domain\Repository\SystemDividendReadModelInterface;
use PocketShares\System\Infrastructure\ReadModel\SystemDividendView;

class ReadModelSystemDividendsRepository extends MysqlRepository implements SystemDividendReadModelInterface
{
    /** @return SystemDividendView[] */
    public function getAllSystemDividends(?int $limit = null, ?int $offset = null): array
    {
        $sql = "SELECT
                dp.id,
                s.ticker,
                dp.payout_date,
                dp.amount ->> '$.amount'  AS dividend_amount,
                dp.amount ->> '$.currency' AS dividend_currency
                FROM dividend_payment dp
                LEFT JOIN stock s ON s.id = dp.stock_id;
                ";

        $results = $this->executeRawQuery($sql)->fetchAllAssociative();

        if (!$results) {
            return [];
        }

        $systemDividendViews = [];

        foreach ($results as $dividend) {
            $systemDividendViews[] = new SystemDividendView(
                id: $dividend['id'],
                stockTicker: $dividend['ticker'],
                payoutDate: \DateTimeImmutable::createFromFormat('Y-m-d', $dividend['payout_date']),
                amount: (int)$dividend['dividend_amount'],
                amountCurrency: $dividend['dividend_currency'],
            );
        }

        return $systemDividendViews;
    }
}