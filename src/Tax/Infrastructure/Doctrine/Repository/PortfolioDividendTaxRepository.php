<?php

declare(strict_types=1);

namespace PocketShares\Tax\Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PocketShares\Tax\Infrastructure\Doctrine\Entity\PortfolioDividendTaxEntity;

class PortfolioDividendTaxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortfolioDividendTaxEntity::class);
    }
}