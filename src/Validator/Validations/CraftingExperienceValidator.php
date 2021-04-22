<?php

declare(strict_types=1);

namespace App\Validator\Validations;

use App\{
    Form\Common\CraftingExperienceType,
    Validator\Constraints\CraftingExperience
};
use Symfony\Component\Validator\{
    Constraint,
    ConstraintValidator,
    Exception\UnexpectedTypeException,
    Exception\UnexpectedValueException
};

final class CraftingExperienceValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($constraint instanceof CraftingExperience === false) {
            throw new UnexpectedTypeException($constraint, CraftingExperience::class);
        }

        if ($value === null) {
            return;
        }

        if (is_numeric($value) === false) {
            throw new UnexpectedValueException($value, 'numeric');
        }

        $value = (int) $value;

        if ($value <= 0) {
            $this->context
                ->buildViolation('L\'expérience métier ne peut être une valeur négative.')
                ->setCode('d773974a-0be2-49f9-b8c5-6eadada38468')
                ->addViolation();

            return;
        }

        if ($value > CraftingExperienceType::MAX_EXPERIENCE) {
            $this->context
                ->buildViolation('Il n\'est pas possible de dépasser la valeur ' . CraftingExperienceType::MAX_EXPERIENCE . '.')
                ->setCode('9de6935f-78dc-4540-90d7-32b6a2471fcf')
                ->addViolation();
        }
    }
}
