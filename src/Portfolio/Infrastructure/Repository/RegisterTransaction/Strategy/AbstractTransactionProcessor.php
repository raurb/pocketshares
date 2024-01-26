<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Repository\RegisterTransaction\Strategy;

use Doctrine\ORM\EntityManagerInterface;
use PocketShares\Portfolio\Domain\Exception\CannotRegisterTransactionNoStock;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;
use PocketShares\Stock\Infrastructure\Doctrine\Repository\StockEntityRepository;

abstract class AbstractTransactionProcessor
{
    public function __construct(protected readonly EntityManagerInterface $entityManager)
    {
    }

    protected function getStockByTicker(string $ticker): StockEntity
    {
        /** @var StockEntityRepository $stockRepository */
        $stockRepository = $this->entityManager->getRepository(StockEntity::class);

        /** @var StockEntity|null $stockEntity */
        $stockEntity = $stockRepository->findOneByTicker($ticker);

        if (!$stockEntity) {
            throw new CannotRegisterTransactionNoStock($ticker);
        }

        return $stockEntity;
    }
}