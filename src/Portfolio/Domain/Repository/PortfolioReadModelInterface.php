<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Repository;

use PocketShares\Portfolio\Infrastructure\ReadModel\PortfolioDetailsView;
use PocketShares\Portfolio\Infrastructure\ReadModel\PortfolioDividendView;
use PocketShares\Portfolio\Infrastructure\ReadModel\PortfolioView;
use PocketShares\Portfolio\Infrastructure\ReadModel\TransactionView;

interface PortfolioReadModelInterface
{
    /** @return PortfolioView[] */
    public function getAllPortfolios(): array;

    public function getPortfolioDetails(int $portfolioId): ?PortfolioDetailsView;

    /** @return TransactionView[] */
    public function getPortfolioTransactions(int $portfolioId): array;

    /** @return PortfolioDividendView[] */
    public function getPortfolioDividends(int $portfolioId, ?\DateTimeImmutable $from = null, ?\DateTimeImmutable $to = null): array;
}