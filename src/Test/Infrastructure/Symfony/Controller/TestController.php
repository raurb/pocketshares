<?php

declare(strict_types=1);

namespace PocketShares\Test\Infrastructure\Symfony\Controller;

use Money\Currency;
use Money\Money;
use PocketShares\ExchangeRates\Application\Command\AddNbpExchangeRates\AddNbpExchangeRatesCommand;
use PocketShares\Shared\Infrastructure\Controller\ApiController;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Domain\Stock;
use PocketShares\System\Application\Command\RegisterSystemDividend\RegisterSystemDividendCommand;
use PocketShares\System\Domain\Event\NewSystemDividendEvent;
use PocketShares\System\Domain\SystemDividendPayment;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test', name: 'test_')]
class TestController extends ApiController
{
    #[Route('/', name: 'test')]
    public function test(): Response
    {
        $command = new RegisterSystemDividendCommand(
            stockTicker: 'QCOM',
            payoutDate: new \DateTimeImmutable(),
            amount: 456,
            amountCurrency: 'USD',
        );

        $this->commandBus->dispatch($command);

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