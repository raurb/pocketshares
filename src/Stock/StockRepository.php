<?php

declare(strict_types=1);

namespace PocketShares\Stock;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StockRepository extends ServiceEntityRepository
{
    public function __construct(private readonly ManagerRegistry $registry)
    {
        parent::__construct($registry, Stock::class);
    }

    public function save(Stock $stock): void
    {
        $this->getEntityManager()->persist($stock);
        $this->getEntityManager()->flush();
    }
}