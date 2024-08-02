<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Application\Command\AddNbpExchangeRates;

use Money\Currency;
use PocketShares\Shared\Application\Command\CommandInterface;

readonly class AddNbpExchangeRatesCommand implements CommandInterface
{
    public function __construct(public Currency $currency, public ?\DateTimeImmutable $startDate = null, public ?\DateTimeImmutable $endDate = null)
    {
    }
}