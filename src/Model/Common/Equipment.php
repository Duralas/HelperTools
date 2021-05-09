<?php

declare(strict_types=1);

namespace App\Model\Common;

use Symfony\Component\Serializer\Annotation\SerializedName;

final class Equipment extends Item
{
    /** @SerializedName("manufacturing_license") */
    protected ?string $manufacturingLicense = null;

    /** @SerializedName("enhancement_license") */
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
