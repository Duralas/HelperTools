<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\Validations\EarnedExperienceValidator;
use Symfony\Component\Validator\Constraint;

/** @Annotation  */
final class EarnedExperience extends Constraint
{
    public function validatedBy(): string
    {
        return EarnedExperienceValidator::class;
    }
}

