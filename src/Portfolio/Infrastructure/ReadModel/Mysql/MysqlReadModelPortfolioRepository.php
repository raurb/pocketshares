<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\ReadModel\Mysql;

use PocketShares\Portfolio\Domain\Repository\PortfolioReadModelInterface;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;
use PocketShares\Portfolio\Infrastructure\ReadModel\PortfolioView;
use PocketShares\Shared\Infrastructure\Persistence\ReadModel\Repository\MysqlRepository;

class MysqlReadModelPortfolioRepository extends MysqlRepository implements PortfolioReadModelInterface
{
    /** @return PortfolioView[] */
    public function getAllPortfolios(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->select(
                'pe.id',
                'pe.name',
                'pe.value',
            )
            ->from(PortfolioEntity::class, 'pe');

        $results = $queryBuilder->getQuery()->getArrayResult();

        if (!$results) {
            return [];
        }

        $portfolios = [];

        foreach ($results as $dbPortfolio) {
            $portfolios[] = new PortfolioView(
                id: $dbPortfolio['id'],
                name: $dbPortfolio['name'],
                value: $dbPortfolio['value'],
            );
        }

        return $portfolios;
    }
}