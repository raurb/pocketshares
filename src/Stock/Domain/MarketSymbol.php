<?php

declare(strict_types=1);

namespace PocketShares\Stock\Domain;

enum MarketSymbol: string
{
    case NYSE = 'NYSE';
    case NASDAQ = 'NASDAQ';
}