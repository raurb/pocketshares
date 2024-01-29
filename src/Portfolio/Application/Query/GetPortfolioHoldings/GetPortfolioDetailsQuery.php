<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Query\GetPortfolioHoldings;

use PocketShares\Shared\Application\Query\QueryInterface;

readonly class GetPortfolioDetailsQuery implements QueryInterface
{
    public function __construct(public int $portfolioId)
    {
    }
}