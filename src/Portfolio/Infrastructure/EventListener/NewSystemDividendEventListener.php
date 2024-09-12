<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\EventListener;

use PocketShares\Portfolio\Application\PortfolioPersister;
use PocketShares\Portfolio\Domain\Portfolio;
use PocketShares\Portfolio\Domain\Repository\PortfolioRepositoryInterface;
use PocketShares\System\Domain\Event\NewSystemDividendEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: NewSystemDividendEvent::class, method: 'registerPortfolioDividend')]
class NewSystemDividendEventListener
{
    public function __construct(
        private readonly PortfolioRepositoryInterface $portfolioRepository,
        private readonly PortfolioPersister $portfolioPersister,
    ) {
    }

    public function registerPortfolioDividend(NewSystemDividendEvent $dividendEvent): void
    {
        $portfolios = $this->portfolioRepository->readManyByStockTicker($dividendEvent->systemDividendPayment->stock->ticker);

        /** @var Portfolio $portfolio */
        foreach ($portfolios as $portfolio) {
            //@todo wyrzucic na asynchroniczna kolejke, albo jeszcze lepiej zrobic listener w przestrzeni Portfolio
            $portfolio->registerDividendPayment($dividendEvent->systemDividendPayment);
            $this->portfolioPersister->persist($portfolio);
        }
    }
}