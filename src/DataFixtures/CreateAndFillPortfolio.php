<?php

namespace PocketShares\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Money\Currency;
use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioHoldingEntity;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioTransactionEntity;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Domain\MarketSymbol;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;

class CreateAndFillPortfolio extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $aaplStock = new StockEntity(
            'Apple Inc.',
            'AAPL',
            MarketSymbol::NYSE,
            new Currency('USD'),
        );

        $broadcom = new StockEntity(
            'Broadcom Inc.',
            'AVGO',
            MarketSymbol::NYSE,
            new Currency('USD'),
        );

        $microsoft = new StockEntity('Microsoft Corp.',
            'MSFT',
            MarketSymbol::NYSE,
            new Currency('USD'),
        );

        $realityIncome = new StockEntity('Reality Income Inc.',
            'O',
            MarketSymbol::NYSE,
            new Currency('USD'),
        );

        $manager->persist($aaplStock);
        $manager->persist($broadcom);
        $manager->persist($microsoft);
        $manager->persist($realityIncome);
        $manager->flush();

        $portfolio = new PortfolioEntity('My first portfolio', 'USD');

        $aaplHolding = new PortfolioHoldingEntity($portfolio, $aaplStock, new NumberOfShares(14));
        $broadcomHolding = new PortfolioHoldingEntity($portfolio, $broadcom, new NumberOfShares(3));
        $microsoftHolding = new PortfolioHoldingEntity($portfolio, $microsoft, new NumberOfShares(5));
        $realityIncomeHolding = new PortfolioHoldingEntity($portfolio, $realityIncome, new NumberOfShares(50));

        $aaplTransaction = new PortfolioTransactionEntity($portfolio,$aaplHolding, new NumberOfShares(12), MoneyFactory::create(1200, 'USD'), new \DateTimeImmutable(), TransactionType::TYPE_BUY);
        $aaplTransaction2 = new PortfolioTransactionEntity($portfolio,$aaplHolding, new NumberOfShares(2), MoneyFactory::create(350, 'USD'), new \DateTimeImmutable(), TransactionType::TYPE_BUY);
        $broadcomTransaction = new PortfolioTransactionEntity($portfolio,$broadcomHolding, new NumberOfShares(3), MoneyFactory::create(3300, 'USD'), new \DateTimeImmutable(), TransactionType::TYPE_BUY);
        $microsoftTransaction = new PortfolioTransactionEntity($portfolio,$microsoftHolding, new NumberOfShares(5), MoneyFactory::create(1750, 'USD'), new \DateTimeImmutable(), TransactionType::TYPE_BUY);
        $realityIncomeTransaction = new PortfolioTransactionEntity($portfolio,$realityIncomeHolding, new NumberOfShares(50), MoneyFactory::create(300, 'USD'), new \DateTimeImmutable(), TransactionType::TYPE_BUY);

        $portfolio->getHoldings()->add($aaplHolding);
        $portfolio->getHoldings()->add($broadcomHolding);
        $portfolio->getHoldings()->add($microsoftHolding);
        $portfolio->getHoldings()->add($realityIncomeHolding);

        $portfolio->getTransactions()->add($aaplTransaction);
        $portfolio->getTransactions()->add($aaplTransaction2);
        $portfolio->getTransactions()->add($broadcomTransaction);
        $portfolio->getTransactions()->add($microsoftTransaction);
        $portfolio->getTransactions()->add($realityIncomeTransaction);

        $manager->persist($portfolio);
        $manager->flush();
    }
}
