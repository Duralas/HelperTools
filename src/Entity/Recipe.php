<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\Column(length=50)
     */
    protected string $registration;

    /** @ORM\Column(length=200) */
    protected string $content;

    public function __construct(string $registration, string $content)
    {
        $this->registration = $registration;
        $this->content = $content;
    }

    public function getRegistration(): string
    {
        return $this->registration;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
