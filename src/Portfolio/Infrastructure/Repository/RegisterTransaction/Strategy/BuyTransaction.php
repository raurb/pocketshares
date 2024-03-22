<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Repository\RegisterTransaction\Strategy;

use PocketShares\Portfolio\Domain\Transaction;
use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioHoldingEntity;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioTransactionEntity;

class BuyTransaction extends AbstractTransactionProcessor implements RegisterTransactionStrategyInterface
{
    public function isSupported(TransactionType $transactionType): bool
    {
        return $transactionType === TransactionType::TYPE_BUY;
    }

    public function handle(PortfolioEntity $portfolioEntity, Transaction $newTransaction): PortfolioEntity
    {
        $stockEntity = $this->getStockByTicker($newTransaction->stock->ticker);
        $holding = $portfolioEntity->getHoldingByTicker($newTransaction->stock->ticker);

        if (!$holding) {
            $holding = new PortfolioHoldingEntity($portfolioEntity, $stockEntity);
            $portfolioEntity->getHoldings()->add($holding);
        }

        $holding->addShares($newTransaction->numberOfShares);

        $newTransactionEntity = new PortfolioTransactionEntity(
            $portfolioEntity,
            $holding,
            $newTransaction->numberOfShares,
            $newTransaction->pricePerShare,
            $newTransaction->transactionDate,
            $newTransaction->transactionType,
        );

        $portfolioEntity->getTransactions()->add($newTransactionEntity);

        return $portfolioEntity;
    }
}