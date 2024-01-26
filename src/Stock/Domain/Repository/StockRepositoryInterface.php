<?php

declare(strict_types=1);

namespace PocketShares\Stock\Domain\Repository;

use PocketShares\Stock\Domain\Stock;

interface StockRepositoryInterface
{
    public function store(Stock $stock): void;

    public function readById(int $stockId): ?Stock;

    public function readByTicker(string $ticker): ?Stock;
}