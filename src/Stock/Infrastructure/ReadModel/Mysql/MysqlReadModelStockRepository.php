<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\ReadModel\Mysql;

use Money\Currency;
use PocketShares\Shared\Infrastructure\Persistence\ReadModel\Repository\MysqlRepository;
use PocketShares\Stock\Domain\MarketSymbol;
use PocketShares\Stock\Infrastructure\Doctrine\Dbal\Entity\StockEntity;
use PocketShares\Stock\Infrastructure\ReadModel\StockView;

class MysqlReadModelStockRepository extends MysqlRepository
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
                marketSymbol: MarketSymbol::from($result['marketSymbol']),
                currency: new Currency($result['currency']),
            );
        }

        return $stocks;
    }
}