<?php

declare(strict_types=1);

namespace App\DBAL;

class ManufacturingLicenseType extends AbstractEnumType
{
    public const ENUM_NAME = 'manufacturingLicense';
    public const MANUFACTURING_LICENSES = [
        'carver',
        'weaponsmith',
        'armorsmith',
    ];

    public function getName(): string
    {
        return static::ENUM_NAME;
    }

    protected function getEnumValues(): array
    {
        return static::MANUFACTURING_LICENSES;
    }

    protected function getInvalidValueMessage($value): string
    {
        return "\"{$value}\" is not a valid manufacturing license.";
    }
}
