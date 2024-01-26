<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Query;

use PocketShares\Portfolio\Domain\Repository\PortfolioReadModelInterface;
use PocketShares\Shared\Application\Query\QueryHandlerInterface;

class GetAllPortfoliosHandler implements QueryHandlerInterface
{
    public function __construct(private readonly PortfolioReadModelInterface $portfolioRepository)
    {
    }

    public function __invoke(GetAllPortfoliosQuery $query): array
    {
        return $this->portfolioRepository->getAllPortfolios();
    }
}