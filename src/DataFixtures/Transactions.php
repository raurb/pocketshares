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
                'ticker' => 'ibkr',
                'numberOfShares' => 0.6,
                'pricePerShare' => 120,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'aapl',
                'numberOfShares' => 4,
                'pricePerShare' => 17823,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'ABT',
                'numberOfShares' => 9,
                'pricePerShare' => 11155,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'ADM',
                'numberOfShares' => 15,
                'pricePerShare' => 5226,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'BAC',
                'numberOfShares' => 23,
                'pricePerShare' => 2742,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'CAT',
                'numberOfShares' => 3,
                'pricePerShare' => 24909,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'GLW',
                'numberOfShares' => 35,
                'pricePerShare' => 3167,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'GPC',
                'numberOfShares' => 9,
                'pricePerShare' => 13063,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'JNJ',
                'numberOfShares' => 7,
                'pricePerShare' => 15495,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'KO',
                'numberOfShares' => 17,
                'pricePerShare' => 5928,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'MCD',
                'numberOfShares' => 4,
                'pricePerShare' => 27516,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'MO',
                'numberOfShares' => 17,
                'pricePerShare' => 4685,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'MSFT',
                'numberOfShares' => 3,
                'pricePerShare' => 31732,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'O',
                'numberOfShares' => 35,
                'pricePerShare' => 5811,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'OKE',
                'numberOfShares' => 12,
                'pricePerShare' => 5850,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'PEP',
                'numberOfShares' => 7,
                'pricePerShare' => 16166,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'PG',
                'numberOfShares' => 8,
                'pricePerShare' => 15024,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'QCOM',
                'numberOfShares' => 7,
                'pricePerShare' => 16947,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'SBUX',
                'numberOfShares' => 16,
                'pricePerShare' => 8575,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'V',
                'numberOfShares' => 5,
                'pricePerShare' => 25129,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
            [
                'portfolio' => 'stocks',
                'ticker' => 'XOM',
                'numberOfShares' => 11,
                'pricePerShare' => 9764,
                'currency' => 'USD',
                'date' => (new \DateTimeImmutable()),
                'type' => TransactionType::TYPE_BUY,
            ],
        ];
    }
}