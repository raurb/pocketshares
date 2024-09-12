<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application;

use PocketShares\Portfolio\Domain\Portfolio;
use PocketShares\Portfolio\Domain\Repository\PortfolioRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class PortfolioPersister
{
    public function __construct(
        private readonly PortfolioRepositoryInterface $portfolioRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function persist(Portfolio $portfolio): void
    {
        $this->portfolioRepository->store($portfolio);
        foreach ($portfolio->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}