<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\Validations\CollectingAreaValidator;
use Symfony\Component\Validator\Constraint;

/** @Annotation  */
final class CollectingArea extends Constraint
{
    public function validatedBy(): string
    {
        return CollectingAreaValidator::class;
    }

}
