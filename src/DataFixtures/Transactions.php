<?php

declare(strict_types=1);

namespace PocketShares\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioHoldingEntity;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioTransactionEntity;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;

class Transactions extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            Stocks::class,
            Portfolios::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getTransactions() as $transaction) {
            /** @var PortfolioEntity $portfolio */
            $portfolioEntity = $this->getReference(\sprintf('portfolio_%s', \strtolower($transaction['portfolio'])), PortfolioEntity::class);

            /** @var StockEntity $stock */
            $stockEntity = $this->getReference(\sprintf('stock_%s', \strtolower($transaction['ticker'])), StockEntity::class);

            $holding = $portfolioEntity->getHoldingByTicker($transaction['ticker']);

            if (!$holding) {
                $holding = new PortfolioHoldingEntity($portfolioEntity, $stockEntity);
                $portfolioEntity->getHoldings()->add($holding);
            }

            $holding->addShares(new NumberOfShares($transaction['numberOfShares']));

            $newTransactionEntity = new PortfolioTransactionEntity(
                $portfolioEntity,
                $holding,
                new NumberOfShares($transaction['numberOfShares']),
                MoneyFactory::create($transaction['pricePerShare'], $transaction['currency']),
                $transaction['date'],
                $transaction['type'],
            );

            $portfolioEntity->getTransactions()->add($newTransactionEntity);
            $manager->persist($portfolioEntity);
        }

        $manager->flush();
    }

    private function getTransactions(): array
    {
        return [
            [
                'portfolio' => 'stocks',
                'ticker' => 'aapl',
                'numberOfShares' => 2,
                'pricePerShare' => 17228,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'glw',
                'numberOfShares' => 5,
                'pricePerShare' => 3257,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'ko',
                'numberOfShares' => 7,
                'pricePerShare' => 6049,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'swk',
                'numberOfShares' => 10,
                'pricePerShare' => 9468,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'mcd',
                'numberOfShares' => 3,
                'pricePerShare' => 28263,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'v',
                'numberOfShares' => 2,
                'pricePerShare' => 28326,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'ibkr',
                'numberOfShares' => 12,
                'pricePerShare' => 10847,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'jnj',
                'numberOfShares' => 17,
                'pricePerShare' => 15523,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'etfs',
                'ticker' => 'spyi',
                'numberOfShares' => 5,
                'pricePerShare' => 5022,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'etfs',
                'ticker' => 'spyi',
                'numberOfShares' => 5,
                'pricePerShare' => 5103,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'ko',
                'numberOfShares' => 3,
                'pricePerShare' => 6124,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
        ];
    }
}