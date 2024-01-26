<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PocketShares\Portfolio\Domain\Holding;
use PocketShares\Portfolio\Domain\Portfolio;
use PocketShares\Portfolio\Domain\Repository\PortfolioRepositoryInterface;
use PocketShares\Portfolio\Domain\Transaction;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioHoldingEntity;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioTransactionEntity;
use PocketShares\Portfolio\Infrastructure\Repository\RegisterTransaction\TransactionRegistryProcessor;
use PocketShares\Stock\Domain\Stock;

class PortfolioRepository implements PortfolioRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface       $entityManager,
        private readonly TransactionRegistryProcessor $transactionStrategyResolver,
    )
    {
    }

    public function store(Portfolio $portfolio): void
    {
        if ($portfolio->getPortfolioId()) {
            $this->updatePortfolio($portfolio);
            return;
        }

        $portfolioEntity = new PortfolioEntity($portfolio->getName(), $portfolio->getCurrency()->getCode());

        $this->entityManager->persist($portfolioEntity);
    }

    public function read(int $portfolioId): ?Portfolio
    {
        $portfolioEntity = $this->getPortfolioEntity($portfolioId);

        if (!$portfolioEntity) {
            return null;
        }

        $holdings = [];
        $transactions = [];

        /** @var PortfolioHoldingEntity $holding */
        foreach ($portfolioEntity->getHoldings() as $holding) {
            $holdingTransactions = [];
            $holdingStock = new Stock(
                ticker: $holding->getStock()->getTicker(),
                name: $holding->getStock()->getName(),
                marketSymbol: $holding->getStock()->getMarketSymbol(),
                currency: $holding->getStock()->getCurrency(),
            );
            /** @var PortfolioTransactionEntity $transaction */
            foreach ($holding->getTransactions() as $transaction) {
                $holdingTransactions[] = $transactions[] = new Transaction(
                    stock: $holdingStock,
                    transactionDate: $transaction->getTransactionDate(),
                    transactionType: $transaction->getTransactionType(),
                    numberOfShares: $transaction->getNumberOfShares(),
                    price: $transaction->getValue(),
                );
            }

            $holdings[] = new Holding($holdingStock, clone $holding->getNumberOfShares(), $holdingTransactions);
        }

        return new Portfolio(
            $portfolioEntity->getName(),
            $portfolioEntity->getValue(),
            $holdings,
            $transactions,
            $portfolioId,
        );
    }

    private function getPortfolioEntity(int $portfolioId): ?PortfolioEntity
    {
        $portfolioRepository = $this->entityManager->getRepository(PortfolioEntity::class);
        return $portfolioRepository->find($portfolioId);
    }

    private function updatePortfolio(Portfolio $portfolio): void
    {
        $portfolioEntity = $this->getPortfolioEntity($portfolio->getPortfolioId());

        if (!$portfolioEntity) {
            return;
        }

        if ($portfolio->getNewTransaction()) {
            $portfolioEntity = $this->registerNewTransaction($portfolioEntity, $portfolio->getNewTransaction());
        }

        $portfolioEntity->setName($portfolio->getName());
        $this->entityManager->persist($portfolioEntity);
        $this->entityManager->flush();
    }

    private function registerNewTransaction(PortfolioEntity $portfolioEntity, Transaction $newTransaction): PortfolioEntity
    {
        return $this->transactionStrategyResolver->process($portfolioEntity, $newTransaction);
    }
}