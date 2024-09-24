<?php

declare(strict_types=1);

namespace PocketShares\Tax\Infrastructure\ReadModel\Mysql;

enum DividendIncomeTaxesOrderBy: string
{
    case DIVIDEND_PAYOUT_DATE = 'DIVIDEND_PAYOUT_DATE';
}