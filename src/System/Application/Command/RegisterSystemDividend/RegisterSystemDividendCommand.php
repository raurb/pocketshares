<?php

declare(strict_types=1);

namespace PocketShares\System\Application\Command\RegisterSystemDividend;

use PocketShares\Shared\Application\Command\CommandInterface;

readonly class RegisterSystemDividendCommand implements CommandInterface
{
    public function __construct(
        public string             $stockTicker,
        public \DateTimeImmutable $payoutDate,
        public int                $amount,
        public string             $amountCurrency,
    )
    {
    }
}