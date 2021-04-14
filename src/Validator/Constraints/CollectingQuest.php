<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\Validations\CollectingQuestValidator;
use Symfony\Component\Validator\Constraint;

/** @Annotation  */
final class CollectingQuest extends Constraint
{
    public function validatedBy(): string
    {
        return CollectingQuestValidator::class;
    }

}
