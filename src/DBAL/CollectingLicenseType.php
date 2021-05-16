<?php

declare(strict_types=1);

namespace App\DBAL;

class CollectingLicenseType extends AbstractEnumType
{
    public const ENUM_NAME = 'collectingLicense';
    public const COLLECTING_LICENSES = [
        'hunter',
        'logger',
        'miner',
    ];

    public function getName(): string
    {
        return static::ENUM_NAME;
    }

    protected function getEnumValues(): array
    {
        return static::COLLECTING_LICENSES;
    }

    protected function getInvalidValueMessage($value): string
    {
        return "\"{$value}\" is not a valid collecting license.";
    }
}
