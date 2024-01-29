<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Persistence\ReadModel\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use Doctrine\ORM\EntityManagerInterface;

class MysqlRepository
{
    protected Connection $connection;

    public function __construct(protected EntityManagerInterface $entityManager)
    {
        $this->connection = $this->entityManager->getConnection();
    }

    protected function executeRawQuery(string $sql, array $bindParameters = []): Result
    {
        return $this->connection->prepare($sql)->executeQuery($bindParameters);
    }
}