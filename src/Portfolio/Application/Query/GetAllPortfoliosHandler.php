<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Query;

use PocketShares\Portfolio\Infrastructure\ReadModel\Mysql\MysqlReadModelPortfolioRepository;
use PocketShares\Shared\Application\Query\QueryHandlerInterface;

class GetAllPortfoliosHandler implements QueryHandlerInterface
{
    public function __construct(private readonly MysqlReadModelPortfolioRepository $portfolioRepository)
    {
    }

    public function __invoke(GetAllPortfoliosQuery $query): array
    {
        return $this->portfolioRepository->getAllPortfolios();
    }
}