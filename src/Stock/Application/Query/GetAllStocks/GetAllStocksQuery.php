<?php

declare(strict_types=1);

namespace PocketShares\Stock\Application\Query\GetAllStocks;

use PocketShares\Shared\Application\Query\QueryInterface;

class GetAllStocksQuery implements QueryInterface
{
    /** @todo change limit and offset */
    public function __construct(public readonly int $limit = 10, public readonly int $offset = 0)
    {
    }
}