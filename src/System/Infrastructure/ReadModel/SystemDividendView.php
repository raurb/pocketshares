<?php

declare(strict_types=1);

namespace PocketShares\System\Infrastructure\ReadModel;

readonly class SystemDividendView
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