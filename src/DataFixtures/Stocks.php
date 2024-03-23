<?php

declare(strict_types=1);

namespace PocketShares\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Money\Currency;
use PocketShares\Stock\Domain\MarketSymbol;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;

class Stocks extends Fixture
{
    private const array STOCKS = [
        'AAPL' => ['name' => 'Apple Inc.', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'ABT' => ['name' => 'Abbott Laboratories', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'ADM' => ['name' => 'Archer Daniels Midland', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'AVGO' => ['name' => 'Broadcom Inc.', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'BAC' => ['name' => 'Bank of America Corp', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'CAT' => ['name' => 'Caterpillar', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'GLW' => ['name' => 'Corning', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'GPC' => ['name' => 'Genuine Parts Company', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'IBKR' => ['name' => 'Interactive Brokers', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'JNJ' => ['name' => 'Johnson & Johnson', 'market' => MarketSymbol::NASDAQ, 'currency' => 'USD'],
        'KO' => ['name' => 'The Coca-Cola Company', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'MCD' => ['name' => 'McDonald’s', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'MSFT' => ['name' => 'Microsoft', 'market' => MarketSymbol::NASDAQ, 'currency' => 'USD'],
        'O' => ['name' => 'Realty Income Corp', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'OKE' => ['name' => 'ONEOK Inc', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'PEP' => ['name' => 'PepsiCo', 'market' => MarketSymbol::NASDAQ, 'currency' => 'USD'],
        'PG' => ['name' => 'Procter & Gamble', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'SBUX' => ['name' => 'Starbucks', 'market' => MarketSymbol::NASDAQ, 'currency' => 'USD'],
        'SPYI' => ['name' => 'NEOS S&P 500 High Income ETF', 'market' => MarketSymbol::BATS, 'currency' => 'USD'],
        'SWK' => ['name' => 'Stanley Black & Decker', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'V' => ['name' => 'Visa', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
        'XOM' => ['name' => 'ExxonMobil', 'market' => MarketSymbol::NYSE, 'currency' => 'USD'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::STOCKS as $ticker => $stock) {
            $stockEntity = new StockEntity(
                name: $stock['name'],
                ticker: $ticker,
                marketSymbol: $stock['market'],
                currency: new Currency($stock['currency']),
            );
            $manager->persist($stockEntity);

            $this->addReference(\sprintf('stock_%s', \strtolower($ticker)), $stockEntity);
        }

        $manager->flush();
    }
}