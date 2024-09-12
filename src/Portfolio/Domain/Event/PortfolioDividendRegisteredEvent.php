<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Event;

use PocketShares\Shared\Domain\Event\DomainEvent;

readonly class PortfolioDividendRegisteredEvent extends DomainEvent
{
    public function __construct(
        public int $portfolioId,
        public int $dividendId,
        string $eventId = null, ?\DateTimeImmutable $occurredOn = null)
    {
        parent::__construct($portfolioId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'portfolio.dividend.registered';
    }
}