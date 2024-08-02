<?php

declare(strict_types=1);

namespace PocketShares\Test\Infrastructure\Symfony\Controller;

use Money\Currency;
use PocketShares\ExchangeRates\Application\Command\AddNbpExchangeRates\AddNbpExchangeRatesCommand;
use PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Nbp;
use PocketShares\Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test', name: 'test_')]
class TestController extends ApiController
{
    #[Route('/', name: 'test')]
    public function test(Nbp $nbp): Response
    {

//        $dateFrom = new \DateTimeImmutable('2020-01-01');
//        $dateTo = (clone $dateFrom)->modify('+ 93 days');
//        $endDate = (new \DateTimeImmutable())->modify('-1 days');
//
//        while ($dateFrom < $endDate) {
//
//            if ($dateTo > $endDate) {
//                $this->commandBus->dispatch(new AddNbpExchangeRatesCommand(new Currency('USD'), $dateFrom, $endDate));
//                exit;
//            }
//
//            $this->commandBus->dispatch(new AddNbpExchangeRatesCommand(new Currency('USD'), $dateFrom, $dateTo));
//
//            $dateFrom = $dateTo->modify('+1 days');
//            $dateTo = (clone $dateFrom)->modify('+ 93 days');
//        }

        return new Response();
    }
}