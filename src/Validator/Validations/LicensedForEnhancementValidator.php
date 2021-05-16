<?php

declare(strict_types=1);

namespace App\Validator\Validations;

use App\{
    Form\Common\CraftingExperienceType,
    Validator\Constraints\LicensedForEnhancement
};
use Symfony\Component\Validator\{
    Constraint,
    ConstraintValidator,
    Exception\UnexpectedTypeException,
    Exception\UnexpectedValueException
};

final class LicensedForEnhancementValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($constraint instanceof LicensedForEnhancement === false) {
            throw new UnexpectedTypeException($constraint, LicensedForEnhancement::class);
        }

        if ($value === null || (is_array($value) && count($value) === 0)) {
            return;
        }

        if (is_array($value) === false) {
            throw new UnexpectedValueException($value, 'array');
        }

        if ($constraint->craftingExperience < CraftingExperienceType::MIN_REQUIREMENT_ENHANCEMENT) {
            $this->context
                ->buildViolation(
                    'Il est nécessaire de dépasser ' . CraftingExperienceType::MIN_REQUIREMENT_ENHANCEMENT .
                    ' points métier pour réaliser des améliorations. Or la valeur actuelle est de : ' .
                    ($constraint->craftingExperience ?? 0) . ' point(s) métier.'
                )
                ->setCode('7f70c81c-1499-4338-b230-9e25270e7f1f')
                ->addViolation();
        }
    }
}
