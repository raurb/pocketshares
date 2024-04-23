<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Repository\RegisterTransaction\Strategy;

use Doctrine\ORM\EntityManagerInterface;
use PocketShares\Portfolio\Domain\Exception\CannotRegisterTransactionNoHolding;
use PocketShares\Portfolio\Domain\Exception\CannotRegisterTransactionNoStock;
use PocketShares\Portfolio\Domain\Exception\CannotSellMoreStocksThanOwnException;
use PocketShares\Portfolio\Domain\Transaction;
use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioTransactionEntity;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;
use PocketShares\Stock\Infrastructure\Doctrine\Repository\StockEntityRepository;

class SellTransaction implements RegisterTransactionStrategyInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function isSupported(TransactionType $transactionType): bool
    {
        return $transactionType === TransactionType::TYPE_SELL;
    }

    public function handle(PortfolioEntity $portfolioEntity, Transaction $newTransaction): PortfolioEntity
    {
        /** @var StockEntityRepository $stockRepository */
        $stockRepository = $this->entityManager->getRepository(StockEntity::class);

        /** @var StockEntity|null $stockEntity */
        $stockEntity = $stockRepository->findOneByTicker($newTransaction->stock->ticker);

        if (!$stockEntity) {
            throw new CannotRegisterTransactionNoStock($newTransaction->stock->ticker);
        }

        $holding = $portfolioEntity->getHoldingByTicker($newTransaction->stock->ticker);

        if (!$holding) {
            throw new CannotRegisterTransactionNoHolding($newTransaction->stock->ticker);
        }

        if ($newTransaction->numberOfShares->getNumberOfShares() > $holding->getNumberOfShares()->getNumberOfShares()) {
            throw new CannotSellMoreStocksThanOwnException(
                $newTransaction->stock->ticker,
                $holding->getNumberOfShares()->getNumberOfShares(),
                $newTransaction->numberOfShares->getNumberOfShares()
            );
        }

        $wasClose = false;
        if ($newTransaction->numberOfShares->getNumberOfShares() === $holding->getNumberOfShares()->getNumberOfShares()) {
            $portfolioEntity->getHoldings()->removeElement($holding);
            $portfolioEntity->getTransactions()->filter(static function (PortfolioTransactionEntity $portfolioTransactionEntity) use ($holding) {
                if ($portfolioTransactionEntity->getPortfolioHolding()?->getId() === $holding->getId()) {
                    $portfolioTransactionEntity->setPortfolioHolding(null);
                }
            });
            $wasClose = true;
            $this->entityManager->remove($holding);
        }

        $holding->reduceShares($newTransaction->numberOfShares);

        $newTransactionEntity = new PortfolioTransactionEntity(
            $portfolioEntity,
            $holding,
            $newTransaction->numberOfShares,
            $newTransaction->pricePerShare,
            $newTransaction->transactionDate,
            $newTransaction->transactionType,
        );

        if ($wasClose) {
            $newTransactionEntity->setPortfolioHolding(null);
        }

        $portfolioEntity->getTransactions()->add($newTransactionEntity);

        return $portfolioEntity;
    }
}