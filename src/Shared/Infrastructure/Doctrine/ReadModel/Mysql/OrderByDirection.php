<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Doctrine\ReadModel\Mysql;

enum OrderByDirection: string
{
    case DESC = 'DESC';
    case ASC = 'ASC';
}
