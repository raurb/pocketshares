<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Query\GetPortfolioHoldings;

use PocketShares\Portfolio\Domain\Repository\PortfolioReadModelInterface;
use PocketShares\Portfolio\Infrastructure\ReadModel\PortfolioDetailsView;
use PocketShares\Shared\Application\Query\QueryHandlerInterface;

class GetPortfolioDetailsHandler implements QueryHandlerInterface
{
    public function __construct(private readonly PortfolioReadModelInterface $portfolioReadModel)
    {
    }

    public function __invoke(GetPortfolioDetailsQuery $detailsQuery): ?PortfolioDetailsView
    {
        return $this->portfolioReadModel->getPortfolioDetails($detailsQuery->portfolioId);
    }
}