<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Query\GetPortfolioDividends;

use PocketShares\Shared\Application\Query\QueryInterface;

readonly class GetPortfolioDividendsQuery implements QueryInterface
{
    public function __construct(public int $portfolioId, public ?\DateTimeImmutable $from = null, public ?\DateTimeImmutable $to = null)
    {
    }
}