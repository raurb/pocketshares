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
            ['portfolio' => 'stocks', 'ticker' => 'PEP', 'payoutDate' => '2024-01-05', 'amount' => 506., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'O', 'payoutDate' => '2024-01-12', 'amount' => 410., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'OKE', 'payoutDate' => '2024-02-14', 'amount' => 1188, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'AAPL', 'payoutDate' => '2024-02-15', 'amount' => 96, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'ABT', 'payoutDate' => '2024-02-15', 'amount' => 275, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'O', 'payoutDate' => '2024-02-15', 'amount' => 410., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'PG', 'payoutDate' => '2024-02-15', 'amount' => 753, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'CAT', 'payoutDate' => '2024-02-20', 'amount' => 390, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'SBUX', 'payoutDate' => '2024-02-23', 'amount' => 456., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'ADM', 'payoutDate' => '2024-02-29', 'amount' => 750, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'V', 'payoutDate' => '2024-03-01', 'amount' => 156, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'JNJ', 'payoutDate' => '2024-03-05', 'amount' => 476, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'XOM', 'payoutDate' => '2024-03-11', 'amount' => 570, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'IBKR', 'payoutDate' => '2024-03-14', 'amount' => 10, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'MSFT', 'payoutDate' => '2024-03-13', 'amount' => 225, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'MCD', 'payoutDate' => '2024-03-15', 'amount' => 501, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'O', 'payoutDate' => '2024-03-15', 'amount' => 410., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'SWK', 'payoutDate' => '2024-03-19', 'amount' => 648, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'AVGO', 'payoutDate' => '2024-04-01', 'amount' => 525, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'BAC', 'payoutDate' => '2024-04-01', 'amount' => 480, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'GPC', 'payoutDate' => '2024-04-01', 'amount' => 500, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'KO', 'payoutDate' => '2024-04-01', 'amount' => 825, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'PEP', 'payoutDate' => '2024-04-01', 'amount' => 506., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'O', 'payoutDate' => '2024-04-15', 'amount' => 411., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'SPYI', 'payoutDate' => '2024-04-29', 'amount' => 342, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'ABT', 'payoutDate' => '2024-05-15', 'amount' => 495, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'O', 'payoutDate' => '2024-05-15', 'amount' => 411., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'OKE', 'payoutDate' => '2024-05-15', 'amount' => 1188, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'PG', 'payoutDate' => '2024-05-15', 'amount' => 805., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'AAPL', 'payoutDate' => '2024-05-15', 'amount' => 100, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'CAT', 'payoutDate' => '2024-05-20', 'amount' => 390, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'SPYI', 'payoutDate' => '2024-05-24', 'amount' => 350, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'SBUX', 'payoutDate' => '2024-05-31', 'amount' => 456., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'V', 'payoutDate' => '2024-06-03', 'amount' => 156, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'JNJ', 'payoutDate' => '2024-06-04', 'amount' => 868, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'ADM', 'payoutDate' => '2024-06-05', 'amount' => 750, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'XOM', 'payoutDate' => '2024-06-10', 'amount' => 570, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'MSFT', 'payoutDate' => '2024-06-13', 'amount' => 225, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'O', 'payoutDate' => '2024-06-14', 'amount' => 420, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'MCD', 'payoutDate' => '2024-06-17', 'amount' => 501, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'SWK', 'payoutDate' => '2024-06-18', 'amount' => 648, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'GLW', 'payoutDate' => '2024-06-27', 'amount' => 980., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'SPYI', 'payoutDate' => '2024-06-27', 'amount' => 354, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'BAC', 'payoutDate' => '2024-06-28', 'amount' => 480, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'AVGO', 'payoutDate' => '2024-06-28', 'amount' => 525, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'PEP', 'payoutDate' => '2024-06-28', 'amount' => 542, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'GPC', 'payoutDate' => '2024-07-01', 'amount' => 500, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'KO', 'payoutDate' => '2024-07-01', 'amount' => 825, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'MO', 'payoutDate' => '2024-07-10', 'amount' => 1176, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'O', 'payoutDate' => '2024-07-15', 'amount' => 421, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'SPYI', 'payoutDate' => '2024-07-25', 'amount' => 356, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'OKE', 'payoutDate' => '2024-08-14', 'amount' => 1188, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'AAPL', 'payoutDate' => '2024-08-15', 'amount' => 100, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'ABT', 'payoutDate' => '2024-08-15', 'amount' => 495, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'O', 'payoutDate' => '2024-08-15', 'amount' => 500, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'PG', 'payoutDate' => '2024-08-15', 'amount' => 805., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'CAT', 'payoutDate' => '2024-08-20', 'amount' => 423., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'SPYI', 'payoutDate' => '2024-08-22', 'amount' => 389, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'SBUX', 'payoutDate' => '2024-08-30', 'amount' => 912., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'V', 'payoutDate' => '2024-09-03', 'amount' => 260, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'NVDY', 'payoutDate' => '2024-09-09', 'amount' => 3658, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'JNJ', 'payoutDate' => '2024-09-10', 'amount' => 868, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'XOM', 'payoutDate' => '2024-09-10', 'amount' => 1045, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'ADM', 'payoutDate' => '2024-09-12', 'amount' => 750, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'MSFT', 'payoutDate' => '2024-09-13', 'amount' => 225, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'O', 'payoutDate' => '2024-09-13', 'amount' => 921., 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'MCD', 'payoutDate' => '2024-09-17', 'amount' => 501, 'currency' => 'USD'],
        ];
    }
}