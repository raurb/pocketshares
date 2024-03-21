<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Query\GetPortfolioDividends;

use PocketShares\Portfolio\Domain\Repository\PortfolioReadModelInterface;
use PocketShares\Shared\Application\Query\QueryHandlerInterface;

readonly class GetPortfolioDividendsHandler implements QueryHandlerInterface
{
    public function __construct(private PortfolioReadModelInterface $portfolioReadModel)
    {
    }

    public function __invoke(GetPortfolioDividendsQuery $portfolioTransactionsQuery): array
    {
        return $this->portfolioReadModel->getPortfolioDividends(
            $portfolioTransactionsQuery->portfolioId,
            $portfolioTransactionsQuery->from,
            $portfolioTransactionsQuery->to,
        );
    }
}