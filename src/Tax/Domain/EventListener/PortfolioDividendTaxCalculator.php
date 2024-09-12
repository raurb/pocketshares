<?php

declare(strict_types=1);

namespace PocketShares\Tax\Domain\EventListener;

use PocketShares\Portfolio\Domain\Event\PortfolioDividendRegisteredEvent;
use PocketShares\Shared\Application\Query\QueryBusInterface;
use PocketShares\Tax\Application\Query\GetDividendTaxData\GetDividendTaxDataQuery;
use PocketShares\Tax\Domain\DividendTax;
use PocketShares\Tax\Infrastructure\ReadModel\DividendTaxDataView;
use PocketShares\Tax\Infrastructure\Repository\DividendTaxRepository;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: PortfolioDividendRegisteredEvent::class, method: 'calculate')]
readonly class PortfolioDividendTaxCalculator
{
    public function __construct(private QueryBusInterface $queryBus, private DividendTaxRepository $dividendTaxRepository)
    {
    }

    public function calculate(PortfolioDividendRegisteredEvent $dividendRegisteredEvent): void
    {
        /** @var DividendTaxDataView|null $data */
        $data = $this->queryBus->dispatch(new GetDividendTaxDataQuery($dividendRegisteredEvent->portfolioId, $dividendRegisteredEvent->dividendId));

        $dividendTax = new DividendTax(
            portfolioId: $data->portfolioId,
            dividendId: $data->dividendId,
            stockTicker: $data->stockTicker,
            dividendGrossAmount: $data->grossAmount,
            incomeTaxCurrency: $data->incomeTaxCurrency,
            portfolioWithholdingTaxRate: $data->portfolioWithholdingTaxRate,
            incomeTaxRate: $data->portfolioIncomeTaxRate,
            exchangeRate: $data->exchangeRate,
            stockWithholdingTaxRate: $data->stockWithholdingTaxRate,
        );

        $this->dividendTaxRepository->store($dividendTax);
    }
}