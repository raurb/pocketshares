<?php

declare(strict_types=1);

namespace PocketShares\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Money\Currency;
use PocketShares\ExchangeRates\Application\Command\AddNbpExchangeRates\AddNbpExchangeRatesCommand;
use PocketShares\Shared\Application\Command\CommandBusInterface;

class ExchangeRates extends Fixture
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $dateFrom = new \DateTimeImmutable('2020-01-01');
        $dateTo = (clone $dateFrom)->modify('+ 93 days');
        $endDate = (new \DateTimeImmutable())->modify('-1 days');

        while ($dateFrom < $endDate) {

            if ($dateTo > $endDate) {
                $this->commandBus->dispatch(new AddNbpExchangeRatesCommand(new Currency('USD'), $dateFrom, $endDate));
                break;
            }

            $this->commandBus->dispatch(new AddNbpExchangeRatesCommand(new Currency('USD'), $dateFrom, $dateTo));

            $dateFrom = $dateTo->modify('+1 days');
            $dateTo = (clone $dateFrom)->modify('+ 93 days');
        }

        $manager->flush();
    }
}