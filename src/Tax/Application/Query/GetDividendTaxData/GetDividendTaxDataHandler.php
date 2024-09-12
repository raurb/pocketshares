<?php

declare(strict_types=1);

namespace PocketShares\Tax\Application\Query\GetDividendTaxData;

use PocketShares\Shared\Application\Query\QueryHandlerInterface;
use PocketShares\Tax\Domain\Repository\TaxReadModelInterface;
use PocketShares\Tax\Infrastructure\ReadModel\DividendTaxDataView;

readonly class GetDividendTaxDataHandler implements QueryHandlerInterface
{
    public function __construct(private TaxReadModelInterface $taxReadModel)
    {
    }

    public function __invoke(GetDividendTaxDataQuery $dividendTaxDataQuery): ?DividendTaxDataView
    {
        return $this->taxReadModel->getDividendTaxData($dividendTaxDataQuery->portfolioId, $dividendTaxDataQuery->dividendId);
    }
}