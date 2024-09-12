<?php

declare(strict_types=1);

namespace PocketShares\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use PocketShares\Shared\Application\Command\CommandBusInterface;
use PocketShares\System\Application\Command\RegisterSystemDividend\RegisterSystemDividendCommand;

class Dividends extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    public function getDependencies(): array
    {
        return [
            Stocks::class,
            Portfolios::class,
            Transactions::class,
//            ExchangeRates::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getDividends() as $dividend) {
            $command = new RegisterSystemDividendCommand(
                stockTicker: $dividend['ticker'],
                payoutDate: \DateTimeImmutable::createFromFormat('Y-m-d', $dividend['payoutDate']),
                amount: (int)$dividend['amount'],
                amountCurrency: $dividend['currency']
            );

            $this->commandBus->dispatch($command);
        }
    }

    private function getDividends(): array
    {
        return [
            ['portfolio' => 'stocks', 'ticker' => 'GPC', 'payoutDate' => '2024-01-02', 'amount' => 475, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'PEP', 'payoutDate' => '2024-01-05', 'amount' => 506, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'O', 'payoutDate' => '2024-01-12', 'amount' => 410, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'OKE', 'payoutDate' => '2024-02-14', 'amount' => 1188, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'AAPL', 'payoutDate' => '2024-02-15', 'amount' => 96, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'ABT', 'payoutDate' => '2024-02-15', 'amount' => 275, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'O', 'payoutDate' => '2024-02-15', 'amount' => 410, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'PG', 'payoutDate' => '2024-02-15', 'amount' => 753, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'CAT', 'payoutDate' => '2024-02-20', 'amount' => 390, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'SBUX', 'payoutDate' => '2024-02-23', 'amount' => 456, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'ADM', 'payoutDate' => '2024-02-29', 'amount' => 750, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'V', 'payoutDate' => '2024-03-01', 'amount' => 156, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'JNJ', 'payoutDate' => '2024-03-05', 'amount' => 476, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'XOM', 'payoutDate' => '2024-03-11', 'amount' => 570, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'MSFT', 'payoutDate' => '2024-03-13', 'amount' => 225, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'MCD', 'payoutDate' => '2024-03-15', 'amount' => 501, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'O', 'payoutDate' => '2024-03-15', 'amount' => 410, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'SWK', 'payoutDate' => '2024-03-19', 'amount' => 648, 'currency' => 'USD'],
        ];
    }
}