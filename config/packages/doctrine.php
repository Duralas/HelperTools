<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\{
    DBAL\CollectingLicenseType,
    DBAL\CraftingLicenseType,
    DBAL\ManufacturingLicenseType,
    DBAL\TradingPostStockType
};

return static function (ContainerConfigurator $container) {
    $container->extension('doctrine', [
        'dbal' => [
            'mapping_types' => [
                'enum'  => 'string',
            ],
            'types' => [
                CollectingLicenseType::ENUM_NAME => CollectingLicenseType::class,
                CraftingLicenseType::ENUM_NAME => CraftingLicenseType::class,
                ManufacturingLicenseType::ENUM_NAME => ManufacturingLicenseType::class,
                TradingPostStockType::ENUM_NAME => TradingPostStockType::class,
            ],
        ],
    ]);
};
