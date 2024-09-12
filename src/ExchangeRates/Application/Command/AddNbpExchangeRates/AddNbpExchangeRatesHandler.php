<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Application\Command\AddNbpExchangeRates;

use Doctrine\ORM\EntityManagerInterface;
use PocketShares\ExchangeRates\Domain\ExchangeRate;
use PocketShares\ExchangeRates\Infrastructure\Doctrine\Entity\ExchangeRateEntity;
use PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Nbp;
use PocketShares\Shared\Application\Command\CommandHandlerInterface;

class AddNbpExchangeRatesHandler implements CommandHandlerInterface
{
    public function __construct(private readonly Nbp $nbp, private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(AddNbpExchangeRatesCommand $command): void
    {
        $rates = $this->nbp->getMidExchangeRatesForCurrency($command->currency, $command->startDate, $command->endDate);

        if (!$rates) {
            return;
        }

        /** @var ExchangeRate $rate */
        foreach ($rates as $rate) {
            $this->entityManager->persist(new ExchangeRateEntity($rate->currencyFrom, $rate->currencyTo, $rate->date, $rate->rate));
        }

        $this->entityManager->flush();
    }
}