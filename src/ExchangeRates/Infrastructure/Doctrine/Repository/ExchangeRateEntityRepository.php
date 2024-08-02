<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PocketShares\ExchangeRates\Infrastructure\Doctrine\Entity\ExchangeRateEntity;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;

/** @method StockEntity|null findOneByTicker(string $stockTicker) */
class ExchangeRateEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExchangeRateEntity::class);
    }
}