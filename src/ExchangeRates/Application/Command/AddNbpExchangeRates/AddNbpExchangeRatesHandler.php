<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Application\Command\AddNbpExchangeRates;

use Doctrine\ORM\EntityManagerInterface;
use PocketShares\ExchangeRates\Domain\ExchangeRate;
use PocketShares\ExchangeRates\Infrastructure\Doctrine\Entity\ExchangeRateEntity;
use PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Nbp;
use PocketShares\Shared\Application\Command\CommandHandlerInterface;
use PocketShares\Shared\Utilities\MoneyFactory;

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
            $precision = \explode('.',(string)$rate->value);
            if (isset($precision[1])) {
                $count = \strlen($precision[1]);
                $rateInt = (int)($rate->value * (10 ** $count));
            } else {
                $rateInt = (int) $rate->value;
            }
            $this->entityManager->persist(new ExchangeRateEntity($rate->fromCurrency, $rate->toCurrency, $rate->date, MoneyFactory::create($rateInt, 'PLN')));
        }

        $this->entityManager->flush();
    }
}