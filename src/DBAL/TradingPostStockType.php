<?php

declare(strict_types=1);

namespace App\DBAL;

class TradingPostStockType extends AbstractEnumType
{
    public const ENUM_NAME = 'tradingPostStock';

    public const TYPE_STOCK_HUNTER = 'stock-hunter';
    public const TYPE_STOCK_LOGGER = 'stock-logger';
    public const TYPE_STOCK_MINER = 'stock-miner';

    public function getName(): string
    {
        return static::ENUM_NAME;
    }

    protected function getEnumValues(): array
    {
        return [
            static::TYPE_STOCK_HUNTER,
            static::TYPE_STOCK_LOGGER,
            static::TYPE_STOCK_MINER,
        ];
    }

    protected function getInvalidValueMessage($value): string
    {
        return $value . ' is not a valid trading post stock type.';
    }
}
