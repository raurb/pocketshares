<?php

declare(strict_types=1);

namespace PocketShares\System\Domain\Event;

use PocketShares\System\Domain\SystemDividendPayment;

readonly class NewSystemDividendEvent
{
    public function __construct(public SystemDividendPayment $systemDividendPayment)
    {
    }
}