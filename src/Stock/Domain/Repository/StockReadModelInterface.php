<?php

declare(strict_types=1);

namespace PocketShares\Stock\Domain\Repository;

use PocketShares\Stock\Infrastructure\ReadModel\StockView;

interface StockReadModelInterface
{
    public function findOneByTicker(string $ticker): ?StockView;

    /** @return StockView[] */
    public function getAllStocks(?int $limit = null, ?int $offset = null): array;
}