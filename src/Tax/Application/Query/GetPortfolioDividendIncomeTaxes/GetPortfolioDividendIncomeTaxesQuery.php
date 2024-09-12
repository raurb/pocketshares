<?php

declare(strict_types=1);

namespace PocketShares\Tax\Application\Query\GetPortfolioDividendIncomeTaxes;

use PocketShares\Shared\Application\Query\QueryInterface;

readonly class GetPortfolioDividendIncomeTaxesQuery implements QueryInterface
{
    // @todo dorobic przedziały dat
    public function __construct(public int $portfolioId)
    {
    }
}