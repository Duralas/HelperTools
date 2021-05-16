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

    public function getManufacturingLicense(): ?string
    {
        return $this->manufacturingLicense;
    }

    /** @return $this */
    public function setManufacturingLicense(?string $manufacturingLicense): self
    {
        $this->manufacturingLicense = $manufacturingLicense;

        return $this;
    }

    public function getEnhancementLicense(): ?string
    {
        return $this->enhancementLicense;
    }

    /** @return $this */
    public function setEnhancementLicense(?string $enhancementLicense): self
    {
        $this->enhancementLicense = $enhancementLicense;

        return $this;
    }
}
