<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\Doctrine\Dbal\Type;

use PocketShares\Shared\Infrastructure\Doctrine\Dbal\EnumType;
use PocketShares\Stock\Domain\MarketSymbol;

class MarketSymbolType extends EnumType
{
    protected function getColumnName(): string
    {
        return 'market_symbol';
    }

    protected function getValues(): array
    {
        return array_column(MarketSymbol::cases(), 'value');
    }
}