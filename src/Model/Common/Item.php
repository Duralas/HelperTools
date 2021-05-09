<?php

declare(strict_types=1);

namespace App\Model\Common;

class Item
{
    protected string $name;

    protected string $registration;

    public function __construct(string $name, string $registration)
    {
        $this->name = $name;
        $this->registration = $registration;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRegistration(): string
    {
        return $this->registration;
    }
}
