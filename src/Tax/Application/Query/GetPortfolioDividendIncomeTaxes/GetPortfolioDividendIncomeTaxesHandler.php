<?php

declare(strict_types=1);

namespace PocketShares\Tax\Application\Query\GetPortfolioDividendIncomeTaxes;

use PocketShares\Shared\Application\Query\QueryHandlerInterface;
use PocketShares\Tax\Domain\Repository\TaxReadModelInterface;

class GetPortfolioDividendIncomeTaxesHandler implements QueryHandlerInterface
{
    public function __construct(private readonly TaxReadModelInterface $taxReadModel)
    {
    }

    public function __invoke(GetPortfolioDividendIncomeTaxesQuery $dividendTaxDataQuery): array
    {
        return $this->taxReadModel->getPortfolioDividendIncomeTaxes($dividendTaxDataQuery->portfolioId);
    }
}