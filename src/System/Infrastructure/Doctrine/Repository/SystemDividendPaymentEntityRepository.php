<?php

declare(strict_types=1);

namespace PocketShares\System\Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;
use PocketShares\System\Infrastructure\Doctrine\Entity\SystemDividendPaymentEntity;

/** @method StockEntity|null findOneByTicker(string $stockTicker) */
class SystemDividendPaymentEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SystemDividendPaymentEntity::class);
    }
}