<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\Doctrine\Dbal\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
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

    public function convertToPHPValue($value, AbstractPlatform $platform): ?MarketSymbol
    {
        return $value ? MarketSymbol::tryFrom($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value ? $value->value : null;
    }
}