<?php

declare(strict_types=1);

namespace PocketShares\Stock\Domain\Repository;

use PocketShares\Stock\Domain\Stock;

interface StockRepositoryInterface
{
    public function find(string $ticker): ?Stock;

    public function store(Stock $stock): void;
}