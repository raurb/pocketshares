<?php

declare(strict_types=1);

namespace PocketShares\Shared\Domain\Event;

use Ramsey\Uuid\Uuid;

readonly abstract class DomainEvent
{
    private string $eventId;
    private \DateTimeImmutable $occurredOn;

    public function __construct(private int $aggregateId, string $eventId = null, ?\DateTimeImmutable $occurredOn = null)
    {
        $this->eventId = $eventId ?: Uuid::uuid4()->toString();
        $this->occurredOn = $occurredOn ?: new \DateTimeImmutable();
    }

    abstract public static function eventName(): string;

    final public function aggregateId(): int
    {
        return $this->aggregateId;
    }

    final public function eventId(): string
    {
        return $this->eventId;
    }

    final public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}