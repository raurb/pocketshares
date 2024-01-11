<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Command;

use PocketShares\Portfolio\Domain\Portfolio;
use PocketShares\Portfolio\Domain\Repository\PortfolioRepositoryInterface;
use PocketShares\Shared\Application\Command\CommandHandlerInterface;

class CreatePortfolioHandler implements CommandHandlerInterface
{
    public function __construct(private readonly PortfolioRepositoryInterface $portfolioRepository)
    {
    }

    public function __invoke(CreatePortfolioCommand $command): void
    {
        $this->portfolioRepository->store(Portfolio::create($command->name, $command->currencyCode));
    }
}