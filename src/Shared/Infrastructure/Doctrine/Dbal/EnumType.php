<?php

declare(strict_types=1);

namespace PocketShares\Shared\Infrastructure\Doctrine\Dbal;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class EnumType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $values = array_map(static function($val) { return "'".$val."'"; }, $this->getValues());

        return "ENUM(".implode(", ", $values).")";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if (!in_array($value->value, $this->getValues(), true)) {
            throw new \InvalidArgumentException("Invalid '".$this->getColumnName()."' value.");
        }
        return $value;
    }

    public function getName(): string
    {
        return $this->getColumnName();
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): true
    {
        return true;
    }

    abstract protected function getColumnName(): string;

    abstract protected function getValues(): array;
}
