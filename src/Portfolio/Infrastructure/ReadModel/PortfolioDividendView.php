<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\ReadModel;

readonly class PortfolioDividendView
{
    public function __construct(
        public int                $id,
        public string             $stockTicker,
        public \DateTimeImmutable $payoutDate,
        public int                $amount,
        public string             $amountCurrency,
    )
    {
    }
}