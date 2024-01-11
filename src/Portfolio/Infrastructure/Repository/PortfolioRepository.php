<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PocketShares\Portfolio\Domain\Portfolio;
use PocketShares\Portfolio\Domain\Repository\PortfolioRepositoryInterface;
use PocketShares\Portfolio\Infrastructure\Doctrine\PortfolioEntity;

class PortfolioRepository implements PortfolioRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function store(Portfolio $portfolio): void
    {
        $portfolioEntity = new PortfolioEntity();
        $portfolioEntity
            ->setName($portfolio->name)
            ->setValue($portfolio->value);

        $this->entityManager->persist($portfolioEntity);
    }
}