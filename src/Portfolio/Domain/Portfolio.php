<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain;

use Money\Currency;
use Money\Money;
use PocketShares\Portfolio\Domain\Exception\CannotRegisterMoreThanOneTransaction;
use PocketShares\Portfolio\Domain\Exception\CannotRegisterTransactionNoHolding;
use PocketShares\Portfolio\Domain\Exception\CannotSellMoreStocksThanOwn;
use PocketShares\Shared\Domain\AggregateRoot;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Domain\Stock;

class Portfolio extends AggregateRoot
{
    private ?Transaction $newTransaction = null;

    /**
     * @param string $name
     * @param Money $value
     * @param Holding[] $holdings
     * @param array $transactions
     * @param int|null $portfolioId
     */
    public function __construct(
        private string $name,
        private Money  $value, //@todo tutaj ma byc wyliczana wartosc na podstawie wartosci pozycji
        private array  $holdings = [],
        private array  $transactions = [],
        private ?int   $portfolioId = null,
    )
    {
    }

    public static function create(
        string $name,
        string $currencyCode,
    ): self
    {
        return new self($name, MoneyFactory::create(0, $currencyCode), []);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): Money
    {
        return $this->value;
    }

    public function getCurrency(): Currency
    {
        return $this->getValue()->getCurrency();
    }

    /** @return Holding[] */
    public function getHoldings(): array
    {
        return $this->holdings;
    }

    /** @return Transaction[] */
    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function getPortfolioId(): ?int
    {
        return $this->portfolioId;
    }

    public function registerTransaction(Transaction $transaction): void
    {
        if ($this->newTransaction) {
            throw new CannotRegisterMoreThanOneTransaction();
        }

        $this->validateTransaction($transaction);

        $holding = $this->searchForHolding($transaction->stock);

        if (!$holding) {
            $holding = new Holding(
                $transaction->stock,
                new NumberOfShares(0),
            );
        }

        $holding->registerTransaction($transaction);
        $this->transactions[] = $this->newTransaction = $transaction;
    }

    public function getNewTransaction(): ?Transaction
    {
        return $this->newTransaction;
    }

    public function searchForHolding(Stock $stock): ?Holding
    {
        foreach ($this->holdings as $holding) {
            if ($holding->getStock()->ticker === $stock->ticker) {
                return $holding;
            }
        }

        return null;
    }

    private function validateTransaction(Transaction $transaction): void
    {
        match ($transaction->transactionType) {
            TransactionType::TYPE_SELL => $this->validateSellTransaction($transaction),
            TransactionType::TYPE_CLOSE_POSITION => $this->validateClosePosition($transaction),
        };
    }

    private function validateSellTransaction(Transaction $transaction): void
    {
        $holding = $this->searchForHolding($transaction->stock);

        if (!$holding) {
            throw new CannotRegisterTransactionNoHolding($transaction->stock->ticker);
        }

        if ($holding->getNumberOfShares()->getNumberOfShares() > $transaction->numberOfShares->getNumberOfShares()) {
            throw new CannotSellMoreStocksThanOwn(
                $transaction->stock->ticker,
                $holding->getNumberOfShares()->getNumberOfShares(),
                $transaction->numberOfShares->getNumberOfShares()
            );
        }
    }

    private function validateClosePosition(Transaction $transaction): void
    {
        $holding = $this->searchForHolding($transaction->stock);

        if (!$holding) {
            throw new CannotRegisterTransactionNoHolding($transaction->stock->ticker);
        }
    }
}