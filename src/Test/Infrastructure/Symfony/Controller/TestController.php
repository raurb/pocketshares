<?php

declare(strict_types=1);

namespace PocketShares\Test\Infrastructure\Symfony\Controller;

use Money\Currency;
use Money\Money;
use PocketShares\ExchangeRates\Application\Command\AddNbpExchangeRates\AddNbpExchangeRatesCommand;
use PocketShares\ExchangeRates\Domain\ExchangeRate;
use PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Nbp;
use PocketShares\Portfolio\Domain\Event\PortfolioDividendRegisteredEvent;
use PocketShares\Shared\Infrastructure\Controller\ApiController;
use PocketShares\Shared\Utilities\MoneyParser;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Tax\Application\Query\GetPortfolioDividendIncomeTaxes\GetPortfolioDividendIncomeTaxesQuery;
use PocketShares\Tax\Domain\DividendTax;
use PocketShares\Tax\Domain\EventListener\PortfolioDividendTaxCalculator;
use PocketShares\Tax\Domain\Tax;
use PocketShares\Tax\Infrastructure\ReadModel\Mysql\TaxReadModelRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test', name: 'test_')]
class TestController extends ApiController
{
    #[Route('/', name: 'test')]
    public function test(): Response
    {
        $tax = new DividendTax(
            1,
            1,
            'AAPL',
            MoneyFactory::create(96, 'USD'),
            new Currency('PLN'),
            0.15,
            0.19,
            new ExchangeRate(new Currency('USD'), new Currency('PLN'), \DateTimeImmutable::createFromFormat('Y-m-d', '2024-02-15'), 4.0593),
        );

//        $this->fetchNbp();
        return new JsonResponse([]);
    }

    private function fetchNbp(): void
    {
        $dateFrom = new \DateTimeImmutable('2020-01-01');
        $dateTo = (clone $dateFrom)->modify('+ 93 days');
        $endDate = (new \DateTimeImmutable())->modify('-1 days');

        while ($dateFrom < $endDate) {

            if ($dateTo > $endDate) {
                $this->commandBus->dispatch(new AddNbpExchangeRatesCommand(new Currency('USD'), $dateFrom, $endDate));
                exit;
            }

            $this->commandBus->dispatch(new AddNbpExchangeRatesCommand(new Currency('USD'), $dateFrom, $dateTo));

            $dateFrom = $dateTo->modify('+1 days');
            $dateTo = (clone $dateFrom)->modify('+ 93 days');
        }
    }
}