<?php

declare(strict_types=1);

namespace PocketShares\Shared\Application\Query;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): mixed;
}