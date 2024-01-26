<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain;

enum TransactionType: string
{
    case TYPE_BUY = 'BUY';
    case TYPE_SELL = 'SELL';
    case TYPE_CLOSE_POSITION = 'CLOSE_POSITION';
}