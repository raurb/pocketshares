<?php

declare(strict_types=1);

namespace PocketShares\Stock\Application\Query\GetAllStocks;

use PocketShares\Shared\Application\Query\QueryHandlerInterface;
use PocketShares\Stock\Infrastructure\ReadModel\Mysql\MysqlReadModelStockRepository;
use PocketShares\Stock\Infrastructure\ReadModel\StockView;

class GetAllStocksHandler implements QueryHandlerInterface
{
    public function __construct(private readonly MysqlReadModelStockRepository $stockRepository)
    {
    }

    /** @return StockView[] */
    public function __invoke(GetAllStocksQuery $query): array
    {
        return $this->stockRepository->getAllStocks($query->limit, $query->offset);
    }
}