<?php

declare(strict_types=1);

namespace PocketShares\Stock\Application\Command\CreateStock;

use Money\Currency;
use PocketShares\Shared\Application\Command\CommandHandlerInterface;
use PocketShares\Stock\Domain\MarketSymbol;
use PocketShares\Stock\Domain\Repository\StockRepositoryInterface;
use PocketShares\Stock\Domain\Stock;

class CreateStockHandler implements CommandHandlerInterface
{
    public function __construct(private readonly StockRepositoryInterface $stockRepository)
    {
    }

    public function __invoke(CreateStockCommand $command): void
    {
        $stock = Stock::create(
            $command->ticker,
            $command->name,
            MarketSymbol::from($command->marketSymbol),
            new Currency($command->currency));
        $this->stockRepository->store($stock);
    }
}