<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Repository\RegisterTransaction;

use PocketShares\Portfolio\Domain\Exception\CannotHandleTransactionType;
use PocketShares\Portfolio\Domain\Transaction;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;
use PocketShares\Portfolio\Infrastructure\Repository\RegisterTransaction\Strategy\RegisterTransactionStrategyInterface;

class TransactionRegistryProcessor
{
    /** @var RegisterTransactionStrategyInterface[] */
    private iterable $strategies;

    public function __construct(iterable $strategies)
    {
        $this->strategies = $strategies;
    }

    public function process(PortfolioEntity $portfolioEntity, Transaction $transaction): PortfolioEntity
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->isSupported($transaction->transactionType)) {
                return $strategy->handle($portfolioEntity, $transaction);
            }
        }

        throw new CannotHandleTransactionType($transaction->transactionType);
    }
}