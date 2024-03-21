<?php

declare(strict_types=1);

namespace PocketShares\System\Application\Query\GetAllSystemDividends;

use PocketShares\Shared\Application\Query\QueryInterface;

readonly class GetAllSystemDividendsQuery implements QueryInterface
{
    /** @todo change limit and offset */
    public function __construct(public int $limit = 10, public int $offset = 0)
    {
    }
}