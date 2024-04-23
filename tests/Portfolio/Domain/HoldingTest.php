<?php

declare(strict_types=1);

namespace PocketShares\Tests\Portfolio\Domain;

use Money\Currency;
use PHPUnit\Framework\Attributes\DataProvider;
use PocketShares\Portfolio\Domain\Exception\CannotSellMoreStocksThanOwnException;
use PocketShares\Portfolio\Domain\Holding;
use PHPUnit\Framework\TestCase;
use PocketShares\Portfolio\Domain\Transaction;
use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Domain\MarketSymbol;
use PocketShares\Stock\Domain\Stock;

class HoldingTest extends TestCase
{
    private Stock $stockMock;

    public function setUp(): void
    {
        $this->stockMock = new Stock('XYZ', 'name', MarketSymbol::NYSE, new Currency('USD'));
    }

    #[DataProvider('getTransactions')]
    public function testRegisterTransaction(
        float $initialNumberOfShares,
        float $expectedNumberOfShares,
        \DateTimeImmutable $transactionDate,
        TransactionType $transactionType,
        int $pricePerShare,
        string $pricePerShareCurrency,
        ?float $transactionNumberOfShares = null
    ): void
    {
        $holding = new Holding($this->stockMock, new NumberOfShares($initialNumberOfShares));

        if ($transactionType === TransactionType::TYPE_SELL && $transactionNumberOfShares && $transactionNumberOfShares > $initialNumberOfShares) {
            $this->expectException(CannotSellMoreStocksThanOwnException::class);
        }

        $holding->registerTransaction(
            new Transaction(
                $this->stockMock,
                $transactionDate,
                $transactionType,
                MoneyFactory::create($pricePerShare, $pricePerShareCurrency),
                $transactionNumberOfShares ? new NumberOfShares($transactionNumberOfShares): null,
            )
        );

        $this->assertEquals($expectedNumberOfShares, $holding->getNumberOfShares()->getNumberOfShares());
    }

    public static function getTransactions(): array
    {
        return [
            [0, 5, new \DateTimeImmutable(), TransactionType::TYPE_BUY, 1, 'USD', 5],
            [100, 95, new \DateTimeImmutable(), TransactionType::TYPE_SELL, 1, 'USD', 5],
            [100, 105, new \DateTimeImmutable(), TransactionType::TYPE_BUY, 1, 'USD', 5],
            [100, 0, new \DateTimeImmutable(), TransactionType::TYPE_CLOSE_POSITION, 1, 'USD'],
            [100, 100, new \DateTimeImmutable(), TransactionType::TYPE_SELL, 1, 'USD', 105],
        ];
    }
}
