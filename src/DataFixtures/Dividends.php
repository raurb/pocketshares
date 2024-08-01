<?php

declare(strict_types=1);

namespace PocketShares\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\SystemDividendPaymentEntity;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;

class Dividends extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            Stocks::class,
            Portfolios::class,
            Transactions::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getDividends() as $dividend) {
            /** @var PortfolioEntity $portfolio */
            $portfolioEntity = $this->getReference(\sprintf('portfolio_%s', \strtolower($dividend['portfolio'])), PortfolioEntity::class);

            /** @var StockEntity $stock */
            $stockEntity = $this->getReference(\sprintf('stock_%s', \strtolower($dividend['ticker'])), StockEntity::class);

            $dividendEntity = new SystemDividendPaymentEntity($stockEntity, $dividend['payoutDate'], MoneyFactory::create($dividend['amount'], $dividend['currency']));
            $portfolioEntity->addDividendPayment($dividendEntity);
            $manager->persist($portfolioEntity);
        }

        $manager->flush();
    }

    private function getDividends(): array
    {
        return [
            ['portfolio' => 'stocks', 'ticker' => 'aapl', 'payoutDate' => new \DateTimeImmutable(), 'amount' => 98, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'ko', 'payoutDate' => new \DateTimeImmutable(), 'amount' => 823, 'currency' => 'USD'],
            ['portfolio' => 'stocks', 'ticker' => 'v', 'payoutDate' => new \DateTimeImmutable(), 'amount' => 1013, 'currency' => 'USD'],
            ['portfolio' => 'etfs', 'ticker' => 'spyi', 'payoutDate' => new \DateTimeImmutable(), 'amount' => 513, 'currency' => 'USD'],
        ];
    }
}