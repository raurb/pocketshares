<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Controller;

use PocketShares\Shared\Application\Command\CommandBusInterface;
use PocketShares\Shared\Application\Query\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class ApiController extends AbstractController
{
    public function __construct(
        protected readonly CommandBusInterface $commandBus,
        protected readonly QueryBusInterface $queryBus,
    ) {}
}