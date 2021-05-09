<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\Validations\EquipmentValidator;
use Symfony\Component\Validator\Constraint;

/** @Annotation  */
final class Equipment extends Constraint
{
    public bool $multiple = false;

    public ?string $manufacturingLicense = null;

    public ?string $enhancementLicense = null;

    public function validatedBy(): string
    {
        return EquipmentValidator::class;
    }
}
