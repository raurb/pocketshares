<?php

declare(strict_types=1);

namespace PocketShares\Tests\Portfolio\Domain;

use PocketShares\Portfolio\Domain\Exception\BuySellTransactionNoNumberOfSharesException;
use PocketShares\Portfolio\Domain\Transaction;
use PHPUnit\Framework\TestCase;
use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Domain\Stock;

class TransactionTest extends TestCase
{
    private Stock $stockMock;

    public function setUp(): void
    {
        $this->stockMock = $this->createMock(Stock::class);
    }
    public function testConstruct(): void
    {
        $this->expectNotToPerformAssertions();

        new Transaction(
            $this->stockMock,
            new \DateTimeImmutable(),
            TransactionType::TYPE_BUY,
            MoneyFactory::create(1, 'usd'),
            new NumberOfShares(1),
        );
    }

    public function testNoSharesException(): void
    {
        $this->expectException(BuySellTransactionNoNumberOfSharesException::class);

        new Transaction(
            $this->stockMock,
            new \DateTimeImmutable(),
            TransactionType::TYPE_BUY,
            MoneyFactory::create(1, 'usd'),
        );
    }

    public function testZeroSharesException(): void
    {
        $this->expectException(BuySellTransactionNoNumberOfSharesException::class);

        new Transaction(
            $this->stockMock,
            new \DateTimeImmutable(),
            TransactionType::TYPE_BUY,
            MoneyFactory::create(1, 'usd'),
            new NumberOfShares(0),
        );
    }

    public function testZeroPricePerShareException(): void
    {
        $this->expectException(BuySellTransactionNoNumberOfSharesException::class);

        new Transaction(
            $this->stockMock,
            new \DateTimeImmutable(),
            TransactionType::TYPE_BUY,
            MoneyFactory::create(1, 'usd'),
            new NumberOfShares(0),
        );
    }
}
