<?php

declare(strict_types=1);

namespace PocketShares\Tax\Application\Query\GetDividendTaxData;

use PocketShares\Shared\Application\Query\QueryInterface;

readonly class GetDividendTaxDataQuery implements QueryInterface
{
    public function __construct(public int $portfolioId, public int $dividendId)
    {
    }
}