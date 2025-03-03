<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Application\Command\RegisterTransaction;

use PocketShares\Portfolio\Domain\Exception\PortfolioNotFoundException;
use PocketShares\Portfolio\Domain\Repository\PortfolioRepositoryInterface;
use PocketShares\Portfolio\Domain\Transaction;
use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Shared\Application\Command\CommandHandlerInterface;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Domain\Exception\StockTickerNotFoundException;
use PocketShares\Stock\Domain\Repository\StockRepositoryInterface;

class RegisterTransactionHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly PortfolioRepositoryInterface $portfolioRepository,
        private readonly StockRepositoryInterface     $stockRepository,
    )
    {
    }

    public function __invoke(RegisterTransactionCommand $command): void
    {
        $portfolio = $this->portfolioRepository->read($command->portfolioId);

        if (!$portfolio) {
            throw new PortfolioNotFoundException($command->portfolioId);
        }

        $stock = $this->stockRepository->readByTicker($command->stockTicker);

        if (!$stock) {
            throw new StockTickerNotFoundException($command->stockTicker);
        }

        $transaction = new Transaction(
            stock: $stock,
            transactionDate: $command->transactionDate,
            transactionType: TransactionType::tryFrom($command->transactionType),
            pricePerShare: $command->pricePerShare ? MoneyFactory::create($command->pricePerShare, $command->priceCurrency) : null,
            numberOfShares: $command->numberOfShares ? new NumberOfShares($command->numberOfShares) : null,
        );

        $portfolio->registerTransaction($transaction);
        $this->portfolioRepository->store($portfolio);
    }
}