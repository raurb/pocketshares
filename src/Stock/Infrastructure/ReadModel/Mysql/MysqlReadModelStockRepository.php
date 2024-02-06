<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\ReadModel\Mysql;

use PocketShares\Shared\Infrastructure\Persistence\ReadModel\Repository\MysqlRepository;
use PocketShares\Stock\Domain\Repository\StockReadModelInterface;
use PocketShares\Stock\Infrastructure\ReadModel\StockView;

class MysqlReadModelStockRepository extends MysqlRepository implements StockReadModelInterface
{
    /** @return StockView[] */
    public function getAllStocks(?int $limit = null, ?int $offset = null): array
    {
        $sql = "SELECT id, name, ticker, market_symbol, currency FROM stock";

        $results = $this->executeRawQuery($sql)->fetchAllAssociative();

        if (!$results) {
            return [];
        }

        $stocks = [];
        foreach ($results as $result) {
            $stocks[] = new StockView(
                id: $result['id'],
                name: $result['name'],
                ticker: $result['ticker'],
                marketSymbol: $result['market_symbol'],
                currency: $result['currency'],
            );
        }

        return $stocks;
    }

    public function findOneByTicker(string $ticker): ?StockView
    {
        return null;
    }
}