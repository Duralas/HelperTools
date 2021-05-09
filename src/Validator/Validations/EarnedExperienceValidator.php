<?php

declare(strict_types=1);

namespace App\Validator\Validations;

use App\Validator\Constraints\EarnedExperience;
use Symfony\Component\Validator\{
    Constraint,
    ConstraintValidator,
    Exception\UnexpectedTypeException,
    Exception\UnexpectedValueException
};

final class EarnedExperienceValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($constraint instanceof EarnedExperience === false) {
            throw new UnexpectedTypeException($constraint, EarnedExperience::class);
        }

        if ($value === null) {
            return;
        }

        if (is_numeric($value) === false) {
            throw new UnexpectedValueException($value, 'numeric');
        }

        $value = (int) $value;

        if ($value < 0) {
            $this->context
                ->buildViolation('Le gain d\'expérience ne peut être une valeur négative.')
                ->setCode('e20aa729-c7a6-4e63-9559-605022954214')
                ->addViolation();
        }
    }
}
