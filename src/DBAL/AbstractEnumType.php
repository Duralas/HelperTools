<?php

declare(strict_types=1);

namespace App\DBAL;

use Doctrine\DBAL\{
    Platforms\AbstractPlatform,
    Platforms\PostgreSQL94Platform,
    Types\Type
};

abstract class AbstractEnumType extends Type
{
    /** @param array<mixed> $column */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        if ($platform instanceof PostgreSQL94Platform) {
            return 'VARCHAR(' . $column['length'] . ') CHECK (' . $column['name'] . ' IN (\'' .
                implode('\', \'', $this->getEnumValues()) . '\'))';
        }

        return 'ENUM (\'' . implode('\', \'', $this->getEnumValues()) . '\')';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if (in_array($value, $this->getEnumValues(), true) === false) {
            throw new \InvalidArgumentException($this->getInvalidValueMessage($value));
        }

        return $value;
    }

    /** @return array<string> */
    abstract protected function getEnumValues(): array;

    /** @param mixed $value */
    abstract protected function getInvalidValueMessage($value): string;
}
