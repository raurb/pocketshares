<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Repository;

use PocketShares\Portfolio\Domain\Portfolio;

interface PortfolioRepositoryInterface
{
    public function store(Portfolio $portfolio): void;
    public function read(int $portfolioId): ?Portfolio;
}