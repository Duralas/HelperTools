<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *         "item" = Item::class,
 *         "equipment" = Equipment::class,
 *         "crafting_material" = CraftingMaterial::class,
 *      }
 * )
 */
abstract class Item
{
    /**
     * @ORM\Column(length=50)
     */
    protected string $name;

    /**
     * @ORM\Id
     * @ORM\Column(length=50)
     */
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
