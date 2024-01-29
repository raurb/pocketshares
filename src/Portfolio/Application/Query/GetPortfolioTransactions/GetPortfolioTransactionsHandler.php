<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Query\GetPortfolioTransactions;

use PocketShares\Portfolio\Domain\Repository\PortfolioReadModelInterface;
use PocketShares\Shared\Application\Query\QueryHandlerInterface;

readonly class GetPortfolioTransactionsHandler implements QueryHandlerInterface
{
    public function __construct(private PortfolioReadModelInterface $portfolioReadModel)
    {
    }

    public function __invoke(GetPortfolioTransactionsQuery $portfolioTransactionsQuery): array
    {
        return $this->portfolioReadModel->getPortfolioTransactions($portfolioTransactionsQuery->portfolioId);
    }
}