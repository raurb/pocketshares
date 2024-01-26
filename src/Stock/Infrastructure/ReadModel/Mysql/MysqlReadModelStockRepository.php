<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\ReadModel\Mysql;

use PocketShares\Shared\Infrastructure\Persistence\ReadModel\Repository\MysqlRepository;
use PocketShares\Stock\Domain\Repository\StockReadModelInterface;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;
use PocketShares\Stock\Infrastructure\ReadModel\StockView;

class MysqlReadModelStockRepository extends MysqlRepository implements StockReadModelInterface
{
    /** @return StockView[] */
    public function getAllStocks(?int $limit = null, ?int $offset = null): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->select(
                'st.id',
                'st.name',
                'st.ticker',
                'st.marketSymbol',
                'st.currency',
            )
            ->from(StockEntity::class, 'st')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $results = $queryBuilder->getQuery()->getArrayResult();

        if (!$results) {
            return [];
        }

        $stocks = [];
        foreach ($results as $result) {
            $stocks[] = new StockView(
                id: $result['id'],
                name: $result['name'],
                ticker: $result['ticker'],
                marketSymbol: $result['marketSymbol'],
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