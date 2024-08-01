<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PocketShares\Stock\Domain\Repository\StockRepositoryInterface;
use PocketShares\Stock\Domain\Stock;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;

class StockRepository implements StockRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function store(Stock $stock): void
    {
        $this->entityManager->persist(new StockEntity(
            name: $stock->name,
            ticker: $stock->ticker,
            marketSymbol: $stock->marketSymbol,
            currency: $stock->currency,
        ));
    }

    public function readById(int $stockId): ?Stock
    {
        return $this->readOneBy('id', $stockId);
    }

    public function readByTicker(string $ticker): ?Stock
    {
        return $this->readOneBy('ticker', $ticker);
    }

    private function readOneBy(string $property, mixed $value): ?Stock
    {
        $repository = $this->entityManager->getRepository(StockEntity::class);
        $stockEntity = $repository->findOneBy([$property => $value]);

        if (!$stockEntity) {
            return null;
        }

        return new Stock(
            ticker: $stockEntity->getTicker(),
            name: $stockEntity->getName(),
            marketSymbol: $stockEntity->getMarketSymbol(),
            currency: $stockEntity->getCurrency(),
            id: $stockEntity->getId(),
        );
    }
}