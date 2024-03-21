<?php

declare(strict_types=1);

namespace PocketShares\System\Application\Query\GetAllSystemDividends;

use PocketShares\Shared\Application\Query\QueryHandlerInterface;
use PocketShares\Stock\Infrastructure\ReadModel\StockView;
use PocketShares\System\Domain\Repository\SystemDividendReadModelInterface;

readonly class GetAllSystemDividendsHandler implements QueryHandlerInterface
{
    public function __construct(private SystemDividendReadModelInterface $systemDividendReadModel)
    {
    }

    /** @return StockView[] */
    public function __invoke(GetAllSystemDividendsQuery $query): array
    {
        return $this->systemDividendReadModel->getAllSystemDividends($query->limit, $query->offset);
    }
}