<?php

declare(strict_types=1);

namespace App\Model\Common;

class Quest
{
    private string $name;

    private string $reward;

    public function __construct(string $name, string $reward)
    {
        $this->name = $name;
        $this->reward = $reward;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReward(): string
    {
        return $this->reward;
    }
}
