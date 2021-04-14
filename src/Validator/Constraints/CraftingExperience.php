<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\Validations\CraftingExperienceValidator;
use Symfony\Component\Validator\Constraint;

/** @Annotation  */
final class CraftingExperience extends Constraint
{
    public function validatedBy(): string
    {
        return CraftingExperienceValidator::class;
    }
}
