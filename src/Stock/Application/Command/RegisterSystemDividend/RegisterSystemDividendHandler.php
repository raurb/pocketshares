<?php

declare(strict_types=1);

namespace PocketShares\Stock\Application\Command\RegisterSystemDividend;

use PocketShares\Portfolio\Domain\Portfolio;
use PocketShares\Portfolio\Domain\Repository\PortfolioRepositoryInterface;
use PocketShares\Shared\Application\Command\CommandHandlerInterface;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Domain\DividendPayment;
use PocketShares\Stock\Domain\Exception\StockTickerNotFoundException;
use PocketShares\Stock\Domain\Repository\StockRepositoryInterface;

class RegisterSystemDividendHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly StockRepositoryInterface     $stockRepository,
        private readonly PortfolioRepositoryInterface $portfolioRepository,
    )
    {
    }

    public function __invoke(RegisterSystemDividendCommand $command)
    {
        $stock = $this->stockRepository->readByTicker($command->stockTicker);

        if (!$stock) {
            throw new StockTickerNotFoundException($command->stockTicker);
        }

        $dividendPayment = new DividendPayment(
            $stock,
            $command->payoutDate,
            MoneyFactory::create($command->amount, $command->amountCurrency),
        );

        $portfolios = $this->portfolioRepository->readManyByStockTicker($command->stockTicker);

        /** @var Portfolio $portfolio */
        foreach ($portfolios as $portfolio) {
            //@todo wyrzucic na asynchroniczna kolejke
            $portfolio->registerDividendPayment($dividendPayment);
            $this->portfolioRepository->store($portfolio);
        }
    }
}