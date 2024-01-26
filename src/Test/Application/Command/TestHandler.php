<?php

declare(strict_types=1);

namespace PocketShares\Test\Application\Command;

use PocketShares\Shared\Application\Command\CommandHandlerInterface;

class TestHandler implements CommandHandlerInterface
{
    public function __construct(

    ) {}

    public function __invoke(TestCommand $command): void
    {

    }
}