<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Symfony\Form;

use PocketShares\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\Form\AbstractType;

class QueryAwareType extends AbstractType
{
    public function __construct(protected readonly QueryBusInterface $queryBus)
    {
    }
}