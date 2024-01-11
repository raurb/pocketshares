<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Persistence\ReadModel\Repository;

use Doctrine\ORM\EntityManagerInterface;

class MysqlRepository
{
    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }
}