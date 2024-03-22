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
use PocketShares\Portfolio\Infrastructure\Repository\RegisterTransaction\TransactionRegistryProcessor;
use PocketShares\Stock\Domain\DividendPayment;
use PocketShares\Stock\Domain\Stock;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\DividendPaymentEntity;

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

        /** @var PortfolioHoldingEntity $holding */
        foreach ($portfolioEntity->getHoldings() as $holding) {
            $holdingTransactions = [];
            $holdingStock = new Stock(
                ticker: $holding->getStock()->getTicker(),
                name: $holding->getStock()->getName(),
                marketSymbol: $holding->getStock()->getMarketSymbol(),
                currency: $holding->getStock()->getCurrency(),
            );

            $holdings[] = new Holding($holdingStock, clone $holding->getNumberOfShares(), $holdingTransactions);
        }

        return new Portfolio(
            $portfolioEntity->getName(),
            $portfolioEntity->getValue(),
            $holdings,
            $portfolioId,
        );
    }

    /** @return Portfolio[] */
    public function readManyByStockTicker(string $stockTicker): array
    {
        $portfolios = [];
        $connection = $this->entityManager->getConnection();

        $sql = 'SELECT id FROM portfolio WHERE id IN (
                    SELECT portfolio_id FROM portfolio_holding WHERE stock_id = (
                        SELECT id FROM stock WHERE ticker = :ticker
                     )
               )';

        $statement = $connection->prepare($sql);
        $statement->bindValue('ticker', $stockTicker);
        $result = $statement->executeQuery()->fetchAllAssociative();

        if (!$result) {
            return [];
        }

        foreach ($result as $item) {
            $portfolios[] = $this->read($item['id']);
        }

        return $portfolios;
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

        // @todo to bedzie do wywalenia po przeniesieniu transakcji z portfolio
        if ($portfolio->getNewTransaction()) {
            $portfolioEntity = $this->registerNewTransaction($portfolioEntity, $portfolio->getNewTransaction());
        }

        if ($portfolio->getNewDividends()) {
            $portfolioEntity = $this->registerNewDividendPayments($portfolioEntity, $portfolio->getNewDividends());
        }

        $portfolioEntity->setName($portfolio->getName());
        $this->entityManager->persist($portfolioEntity);
        $this->entityManager->flush();
    }

    private function registerNewTransaction(PortfolioEntity $portfolioEntity, Transaction $newTransaction): PortfolioEntity
    {
        return $this->transactionStrategyResolver->process($portfolioEntity, $newTransaction);
    }

    private function registerNewDividendPayments(PortfolioEntity $portfolioEntity, array $registeredDividendPayments): PortfolioEntity
    {
        /** @var DividendPayment $dividendPayment */
        foreach ($registeredDividendPayments as $dividendPayment) {
            $newDividendPayment = new DividendPaymentEntity(
                $portfolioEntity->getStockByTicker($dividendPayment->stock->ticker),
                $dividendPayment->recordDate,
                $dividendPayment->amount,
            );
            $portfolioEntity->addDividendPayment($newDividendPayment);
        }

        return $portfolioEntity;
    }
}