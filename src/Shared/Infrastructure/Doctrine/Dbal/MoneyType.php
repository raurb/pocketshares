<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Doctrine\Dbal;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use Money\Currency;
use Money\Money;
use PocketShares\Shared\Infrastructure\Exception\CannotBuildMoneyException;

class MoneyType extends JsonType
{
    private const TYPE_NAME = 'money_type';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Money
    {
        if (!$value) {
            return null;
        }

        $decoded = json_decode($value, true, 512, JSON_THROW_ON_ERROR);

        if (!isset($decoded['amount'], $decoded['currency'])) {
            throw new CannotBuildMoneyException($value);
        }

        return new Money($decoded['amount'], new Currency($decoded['currency']));
    }

    public function getName(): string
    {
        return self::TYPE_NAME;
    }
}