<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain;

use Money\Currency;
use Money\Money;
use PocketShares\Portfolio\Domain\Event\PortfolioDividendRegisteredEvent;
use PocketShares\Portfolio\Domain\Exception\CannotRegisterDividendNoHolding;
use PocketShares\Portfolio\Domain\Exception\CannotRegisterMoreThanOneTransaction;
use PocketShares\Portfolio\Domain\Exception\CannotRegisterTransactionNoHolding;
use PocketShares\Portfolio\Domain\Exception\CannotSellMoreStocksThanOwnException;
use PocketShares\Shared\Domain\AggregateRoot;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Domain\Stock;
use PocketShares\System\Domain\SystemDividendPayment;
use PocketShares\Tax\Domain\DividendTax;
use PocketShares\Tax\Domain\Tax;

class Portfolio extends AggregateRoot
{
    private const WITHHOLDING_TAX_PERCENT = 0.15;
    private const INCOME_TAX_PERCENT = 0.19;

    private ?Transaction $newTransaction = null;

    /** @var SystemDividendPayment[] */
    private array $newDividends = [];

    /** @var DividendTax[] */
    private array $newDividendTaxes = [];

    public function __construct(
        private readonly string $name,
        private readonly Money  $value, //@todo tutaj ma byc wyliczana wartosc na podstawie wartosci pozycji
        private readonly array  $holdings = [],
        private readonly ?int   $portfolioId = null,
    )
    {
    }

    public static function createNew(
        string $name,
        string $currencyCode,
    ): self
    {
        //@todo zarejestrowac event domenowy
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
        //@todo zamiast nowych transakcji dodav event domenowy
        $this->newTransaction = $transaction;
    }

    public function getNewTransaction(): ?Transaction
    {
        return $this->newTransaction;
    }

    public function getNewDividends(): array
    {
        return $this->newDividends;
    }

    public function getNewDividendTaxes(): array
    {
        return $this->newDividendTaxes;
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

    public function registerDividendPayment(SystemDividendPayment $dividendPayment): void
    {
        $holding = $this->searchForHolding($dividendPayment->stock);
        if (!$holding) {
            throw new CannotRegisterDividendNoHolding($dividendPayment->stock->ticker);
        }

        //@todo zwieksz wartosc

        $this->newDividends[] = $dividendPayment;
        $this->record(new PortfolioDividendRegisteredEvent($this->portfolioId, $dividendPayment->systemDividendId));
    }

    private function validateTransaction(Transaction $transaction): void
    {
        match ($transaction->transactionType) {
            TransactionType::TYPE_SELL => $this->validateSellTransaction($transaction),
            TransactionType::TYPE_CLOSE_POSITION => $this->validateClosePosition($transaction),
            TransactionType::TYPE_BUY => '',
        };
    }

    private function validateSellTransaction(Transaction $transaction): void
    {
        $holding = $this->searchForHolding($transaction->stock);

        if (!$holding) {
            throw new CannotRegisterTransactionNoHolding($transaction->stock->ticker);
        }

        if ($transaction->numberOfShares->getNumberOfShares() > $holding->getNumberOfShares()->getNumberOfShares()) {
            throw new CannotSellMoreStocksThanOwnException(
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