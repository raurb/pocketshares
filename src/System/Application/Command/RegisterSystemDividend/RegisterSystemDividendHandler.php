<?php

declare(strict_types=1);

namespace PocketShares\System\Application\Command\RegisterSystemDividend;

use Doctrine\ORM\EntityManagerInterface;
use PocketShares\Shared\Application\Command\CommandHandlerInterface;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Domain\Exception\StockTickerNotFoundException;
use PocketShares\Stock\Domain\Repository\StockRepositoryInterface;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;
use PocketShares\System\Domain\Event\NewSystemDividendEvent;
use PocketShares\System\Domain\SystemDividendPayment;
use PocketShares\System\Infrastructure\Doctrine\Entity\SystemDividendPaymentEntity;
use Psr\EventDispatcher\EventDispatcherInterface;

class RegisterSystemDividendHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly StockRepositoryInterface $stockRepository,
        private readonly EntityManagerInterface   $entityManager,
        private readonly EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function __invoke(RegisterSystemDividendCommand $command)
    {
        $stock = $this->stockRepository->readByTicker($command->stockTicker);

        if (!$stock) {
            throw new StockTickerNotFoundException($command->stockTicker);
        }

        $dividendEntity = new SystemDividendPaymentEntity(
            $this->entityManager->getReference(StockEntity::class, $stock->id),
            $command->payoutDate,
            MoneyFactory::create($command->amount, $command->amountCurrency),
        );
        $this->entityManager->persist($dividendEntity);
        $this->entityManager->flush();

        $systemDividendPayment = new SystemDividendPayment(
            $stock,
            $command->payoutDate,
            MoneyFactory::create($command->amount, $command->amountCurrency),
            $dividendEntity->getId(),
        );

        $this->eventDispatcher->dispatch(new NewSystemDividendEvent($systemDividendPayment));
    }
}