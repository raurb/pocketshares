<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Query\GetPortfolioTransactions;

use PocketShares\Shared\Application\Query\QueryInterface;

readonly class GetPortfolioTransactionsQuery implements QueryInterface
{
    public function __construct(public int $portfolioId)
    {
    }
}