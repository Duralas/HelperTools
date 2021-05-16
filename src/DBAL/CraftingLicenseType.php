<?php

declare(strict_types=1);

namespace App\DBAL;

class CraftingLicenseType extends AbstractEnumType
{
    public const ENUM_NAME = 'craftingLicense';

    public function getName(): string
    {
        return static::ENUM_NAME;
    }

    protected function getEnumValues(): array
    {
        return [...CollectingLicenseType::COLLECTING_LICENSES, ...ManufacturingLicenseType::MANUFACTURING_LICENSES];
    }

    protected function getInvalidValueMessage($value): string
    {
        return "\"{$value}\" is not a valid crafting license.";
    }
}
