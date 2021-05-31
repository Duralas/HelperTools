<?php

declare(strict_types=1);

namespace App\Entity;

use App\{
    DBAL\TradingPostStockType,
    Repository\TradingPostStockRepository
};
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity(repositoryClass=TradingPostStockRepository::class) */
class TradingPostStock
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity=Item::class)
     * @ORM\JoinColumn(name="item", referencedColumnName="registration")
     */
    protected Item $item;

    /** @ORM\Column(length=50, nullable=true, type=TradingPostStockType::ENUM_NAME) */
    protected string $type;

    /** @ORM\Column(type="integer") */
    protected int $value;

    /** @ORM\Column(type="integer") */
    protected int $count;

    public function __construct(Item $item, int $value, string $type)
    {
        $this->item = $item;
        $this->value = $value;
        $this->type = $type;
    }

    public function getItem(): Item
    {
        return $this->item;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }
}
