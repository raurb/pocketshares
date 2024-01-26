<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Doctrine\Dbal\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use PocketShares\Portfolio\Domain\TransactionType as DomainTransactionType;
use PocketShares\Shared\Infrastructure\Doctrine\Dbal\EnumType;

class TransactionType extends EnumType
{
    protected function getColumnName(): string
    {
        return 'transaction_type';
    }

    protected function getValues(): array
    {
        return array_column(DomainTransactionType::cases(), 'value');
    }

    public function convertToPHPValue($type, AbstractPlatform $platform): ?DomainTransactionType
    {
        if (!$type) {
            return null;
        }

        return DomainTransactionType::tryFrom($type);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value ? $value->value : null;
    }
}