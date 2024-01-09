<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Bus;

use PocketShares\Shared\Application\Query\QueryBusInterface;
use PocketShares\Shared\Application\Query\QueryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessengerQueryBus implements QueryBusInterface
{
    public function __construct(private readonly MessageBusInterface $messengerBusQuery)
    {
    }

    public function ask(QueryInterface $query): mixed
    {
        $envelope = $this->messengerBusQuery->dispatch($query);

        /** @var HandledStamp $stamp */
        $stamp = $envelope->last(HandledStamp::class);

        return $stamp->getResult();
    }
}