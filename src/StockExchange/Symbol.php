<?php

declare(strict_types=1);

namespace PocketShares\StockExchange;

enum Symbol: string
{
    case NYSE = 'NYSE';
    case NASDAQ = 'NASDAQ';
}