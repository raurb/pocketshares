<?php

declare(strict_types=1);

namespace PocketShares\Test\Infrastructure\Symfony\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Money\Currency;
use PocketShares\ExchangeRates\Provider\Nbp\Nbp;
use PocketShares\Shared\Infrastructure\Controller\ApiController;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\DividendPaymentEntity;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test', name: 'test_')]
class TestController extends ApiController
{
    #[Route('/', name: 'test')]
    public function test(Nbp $nbp): Response
    {
        $rates = $nbp->getMidExchangeRatesForCurrency(new Currency('USD'), new \DateTimeImmutable('2024-05-15'), new \DateTimeImmutable('2024-05-16'));
        return new Response();
    }
}