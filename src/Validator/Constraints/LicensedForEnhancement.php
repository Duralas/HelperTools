<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\Validations\LicensedForEnhancementValidator;
use Symfony\Component\Validator\Constraint;

/** @Annotation  */
final class LicensedForEnhancement extends Constraint
{
    public ?int $craftingExperience = null;

    public function validatedBy(): string
    {
        return LicensedForEnhancementValidator::class;
    }
}
