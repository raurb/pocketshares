<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Doctrine\Dbal;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use Money\Money;
use PocketShares\Shared\Infrastructure\Exception\CannotBuildMoneyException;
use PocketShares\Shared\Utilities\MoneyFactory;

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

        return MoneyFactory::create((int)$decoded['amount'], $decoded['currency']);
    }

    public function getName(): string
    {
        return self::TYPE_NAME;
    }
}