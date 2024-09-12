<?php

declare(strict_types=1);

namespace PocketShares\Tax\Domain\Repository;

use PocketShares\Tax\Infrastructure\ReadModel\DividendTaxDataView;

interface TaxReadModelInterface
{
    public function getDividendTaxData(int $portfolioId, int $dividendId): ?DividendTaxDataView;
    public function getPortfolioDividendIncomeTaxes(int $portfolioId);
}