<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Doctrine\Dbal;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DecimalType;
use PocketShares\Shared\Domain\NumberOfShares;

class NumberOfSharesType extends DecimalType
{
    private const TYPE_NAME = 'number_of_shares_type';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?NumberOfShares
    {
        return $value ? new NumberOfShares((float)$value) : null;
    }

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value ? $value->getNumberOfShares() : null;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): true
    {
        return true;
    }
}