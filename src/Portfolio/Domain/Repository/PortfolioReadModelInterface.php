<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Repository;

use PocketShares\Portfolio\Infrastructure\ReadModel\PortfolioView;

interface PortfolioReadModelInterface
{
    /** @return PortfolioView[] */
    public function getAllPortfolios(): array;
}