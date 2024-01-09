<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PocketShares\Stock\Domain\Repository\StockRepositoryInterface;
use PocketShares\Stock\Domain\Stock;
use PocketShares\Stock\Infrastructure\Doctrine\Dbal\Entity\StockEntity;

class StockRepository implements StockRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function find(string $ticker): ?Stock
    {
        // TODO: Implement get() method.
    }

    public function store(Stock $stock): void
    {
        $this->entityManager->persist(new StockEntity(
            name: $stock->name,
            ticker: $stock->ticker,
            marketSymbol: $stock->marketSymbol->value,
            currency: $stock->currency->getCode(),
        ));
    }
}