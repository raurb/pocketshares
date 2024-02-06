<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain;

enum TransactionType: string
{
    case TYPE_BUY = 'BUY';
    case TYPE_SELL = 'SELL';
    case TYPE_CLOSE_POSITION = 'CLOSE_POSITION';

    public static function getLabels(): array
    {
        return [
            self::TYPE_BUY->value => self::TYPE_BUY->value,
            self::TYPE_SELL->value => self::TYPE_SELL->value,
            self::TYPE_CLOSE_POSITION->value => self::TYPE_CLOSE_POSITION->value,
        ];
    }
}