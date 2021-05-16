<?php

namespace App\Entity;

use App\{
    DBAL\ManufacturingLicenseType,
    Repository\EquipmentRepository
};
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass=EquipmentRepository::class)
 */
class Equipment extends Item
{
    /**
     * @ORM\Column(length=20, nullable=true, type=ManufacturingLicenseType::ENUM_NAME)
     * @SerializedName("manufacturing_license")
     */
    protected ?string $manufacturingLicense = null;

    /**
     * @ORM\Column(length=20, nullable=true, type=ManufacturingLicenseType::ENUM_NAME)
     * @SerializedName("enhancement_license")
     */
    protected ?string $enhancementLicense = null;

    /**
     * @ORM\OneToOne(targetEntity=Recipe::class)
     * @ORM\JoinColumn(name="recipe", referencedColumnName="registration")
     */
    protected ?Recipe $recipe = null;

    public function getManufacturingLicense(): ?string
    {
        return $this->manufacturingLicense;
    }

    public function getEnhancementLicense(): ?string
    {
        return $this->enhancementLicense;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    /** @return $this */
    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }
}
