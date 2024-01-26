<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;

/** @method StockEntity|null findOneByTicker(string $stockTicker) */
class StockEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockEntity::class);
    }
}