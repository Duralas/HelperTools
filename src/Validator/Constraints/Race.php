<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\Validations\RaceValidator;
use Symfony\Component\Validator\Constraint;

/** @Annotation */
final class Race extends Constraint
{
    public function validatedBy(): string
    {
        return RaceValidator::class;
    }
}
