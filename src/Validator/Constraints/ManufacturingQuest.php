<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\Validations\ManufacturingQuestValidator;
use Symfony\Component\Validator\Constraint;

/** @Annotation  */
final class ManufacturingQuest extends Constraint
{
    public function validatedBy(): string
    {
        return ManufacturingQuestValidator::class;
    }

}
