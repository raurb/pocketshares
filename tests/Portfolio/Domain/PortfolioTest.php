<?php

declare(strict_types=1);

namespace PocketShares\Tests\Portfolio\Domain;

use Money\Currency;
use PocketShares\Portfolio\Domain\Exception\CannotRegisterDividendNoHolding;
use PocketShares\Portfolio\Domain\Exception\CannotRegisterMoreThanOneTransaction;
use PocketShares\Portfolio\Domain\Exception\CannotRegisterTransactionNoHolding;
use PocketShares\Portfolio\Domain\Exception\CannotSellMoreStocksThanOwnException;
use PocketShares\Portfolio\Domain\Holding;
use PocketShares\Portfolio\Domain\Portfolio;
use PHPUnit\Framework\TestCase;
use PocketShares\Portfolio\Domain\Transaction;
use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Domain\MarketSymbol;
use PocketShares\Stock\Domain\Stock;
use PocketShares\System\Domain\SystemDividendPayment;

class PortfolioTest extends TestCase
{
    private Portfolio $portfolio;
    private Stock $stockMock;

    public function setUp(): void
    {
        $this->portfolio = new Portfolio(
            'test',
            MoneyFactory::create(0, 'USD'),
            [],
        );

        $this->stockMock = new Stock('XYZ', 'name', MarketSymbol::NYSE, new Currency('USD'));
    }

    public function testCreateNew(): void
    {
        $this->assertEquals($this->portfolio, Portfolio::createNew('test', 'usd'));
    }

    public function testRegisterBuyTransaction(): void
    {
        $transaction = new Transaction(
            $this->stockMock,
            new \DateTimeImmutable(),
            TransactionType::TYPE_BUY,
            MoneyFactory::create(1, 'usd'),
            new NumberOfShares(5),
        );

        $this->portfolio->registerTransaction($transaction);

        $this->assertEquals($transaction, $this->portfolio->getNewTransaction());
    }

    public function testCannotRegisterMoreThanOneTransaction(): void
    {
        $transaction = new Transaction(
            $this->stockMock,
            new \DateTimeImmutable(),
            TransactionType::TYPE_BUY,
            MoneyFactory::create(1, 'usd'),
            new NumberOfShares(5),
        );

        $this->portfolio->registerTransaction($transaction);

        $this->expectException(CannotRegisterMoreThanOneTransaction::class);

        $this->portfolio->registerTransaction($transaction);
    }

    public function testRegisterSellTransactionNoHolding(): void
    {
        $transaction = new Transaction(
            $this->stockMock,
            new \DateTimeImmutable(),
            TransactionType::TYPE_SELL,
            MoneyFactory::create(1, 'usd'),
            new NumberOfShares(5),
        );

        $this->expectException(CannotRegisterTransactionNoHolding::class);

        $this->portfolio->registerTransaction($transaction);
    }

    public function testRegisterSellTransactionSellMoreSharesThanOwn(): void
    {
        $stock = new Stock('test', 'test', MarketSymbol::NYSE, new Currency('usd'));
        $sellTransaction = new Transaction(
            $stock,
            new \DateTimeImmutable(),
            TransactionType::TYPE_SELL,
            MoneyFactory::create(1, 'usd'),
            new NumberOfShares(50),
        );

        $portfolio = new Portfolio('test', MoneyFactory::create(1, 'usd'), [
            new Holding($stock, new NumberOfShares(10)),
        ]);

        $this->expectException(CannotSellMoreStocksThanOwnException::class);

        $portfolio->registerTransaction($sellTransaction);
    }

    public function testRegisterClosePositionTransactionNoHolding(): void
    {
        $transaction = new Transaction(
            new Stock('test', 'test', MarketSymbol::NYSE, new Currency('usd')),
            new \DateTimeImmutable(),
            TransactionType::TYPE_CLOSE_POSITION,
            MoneyFactory::create(1, 'usd'),
        );

        $this->expectException(CannotRegisterTransactionNoHolding::class);

        $this->portfolio->registerTransaction($transaction);
    }

    public function testRegisterDividendPayment(): void
    {
        $portfolio = new Portfolio('test', MoneyFactory::create(1, 'usd'), [
            new Holding($this->stockMock, new NumberOfShares(10)),
        ]);

        $dividend = new SystemDividendPayment(0, $this->stockMock, new \DateTimeImmutable(), MoneyFactory::create(5, 'USD'));

        $portfolio->registerDividendPayment($dividend);

        $this->assertEquals($dividend, \current($portfolio->getNewDividends()));
    }

    public function testRegisterDividendNoHolding(): void
    {
        $dividend = new SystemDividendPayment(0, $this->stockMock, new \DateTimeImmutable(), MoneyFactory::create(5, 'USD'));

        $this->expectException(CannotRegisterDividendNoHolding::class);

        $this->portfolio->registerDividendPayment($dividend);
    }
}
