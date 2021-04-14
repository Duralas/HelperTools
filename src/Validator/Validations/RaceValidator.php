<?php

declare(strict_types=1);

namespace App\Validator\Validations;

use App\{
    Form\Common\RaceType,
    Validator\Constraints\Race
};
use Symfony\Component\Validator\{
    Constraint,
    ConstraintValidator,
    Exception\UnexpectedTypeException
};

final class RaceValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($constraint instanceof Race === false) {
            throw new UnexpectedTypeException($constraint, Race::class);
        }

        if (in_array($value, RaceType::RACE_CHOICES, true) === false) {
            $this->context
                ->buildViolation('La race ne correspond à aucune jouable.')
                ->setCode('ab722d01-6c4a-479b-bab4-842728855305')
                ->addViolation();
        }
    }
}
