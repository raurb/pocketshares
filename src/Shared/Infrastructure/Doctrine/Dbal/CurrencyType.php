<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Doctrine\Dbal;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Money\Currency;
use PocketShares\Shared\Domain\NumberOfShares;

class CurrencyType extends StringType
{
    private const TYPE_NAME = 'currency_type';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Currency
    {
        return $value ? new Currency($value) : null;
    }

    public function getName(): string
    {
        return self::TYPE_NAME;
    }
}