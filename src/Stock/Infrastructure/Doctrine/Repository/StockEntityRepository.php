<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;

class StockEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockEntity::class);
    }
}