<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Repository\RegisterTransaction\Strategy;

use PocketShares\Portfolio\Domain\Exception\CannotRegisterTransactionNoHolding;
use PocketShares\Portfolio\Domain\Transaction;
use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioTransactionEntity;

class CloseTransaction extends AbstractTransactionProcessor implements RegisterTransactionStrategyInterface
{
    public function isSupported(TransactionType $transactionType): bool
    {
        return $transactionType === TransactionType::TYPE_CLOSE_POSITION;
    }

    public function handle(PortfolioEntity $portfolioEntity, Transaction $newTransaction): PortfolioEntity
    {
        $holding = $portfolioEntity->getHoldingByTicker($newTransaction->stock->ticker);

        if (!$holding) {
            throw new CannotRegisterTransactionNoHolding($newTransaction->stock->ticker);
        }

        $portfolioEntity->getHoldings()->removeElement($holding);
        $portfolioEntity->getTransactions()->filter(static function (PortfolioTransactionEntity $portfolioTransactionEntity) use ($holding) {
            if ($portfolioTransactionEntity->getPortfolioHolding()?->getId() === $holding->getId()) {
                $portfolioTransactionEntity->setPortfolioHolding(null);
            }
        });

        $newTransactionEntity = new PortfolioTransactionEntity(
            $portfolioEntity,
            $holding,
            $holding->getNumberOfShares(),
            $newTransaction->price,
            $newTransaction->transactionDate,
            $newTransaction->transactionType,
        );

        $newTransactionEntity->setPortfolioHolding(null);
        $portfolioEntity->getTransactions()->add($newTransactionEntity);
        $this->entityManager->remove($holding);

        return $portfolioEntity;
    }
}