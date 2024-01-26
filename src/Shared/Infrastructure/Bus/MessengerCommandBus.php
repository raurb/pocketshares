<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Bus;

use PocketShares\Shared\Application\Command\CommandBusInterface;
use PocketShares\Shared\Application\Command\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBusInterface
{
    public function __construct(private readonly MessageBusInterface $messengerBusCommand)
    {
    }

    public function dispatch(CommandInterface $command): void
    {
        $this->messengerBusCommand->dispatch($command);
    }
}