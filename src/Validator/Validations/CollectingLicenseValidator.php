<?php

declare(strict_types=1);

namespace App\Validator\Validations;

use App\{
    DBAL\CollectingLicenseType,
    Validator\Constraints\CollectingLicense
};
use Symfony\Component\Validator\{
    Constraint,
    ConstraintValidator,
    Exception\UnexpectedTypeException
};

final class CollectingLicenseValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($constraint instanceof CollectingLicense === false) {
            throw new UnexpectedTypeException($constraint, CollectingLicense::class);
        }

        if (in_array($value, CollectingLicenseType::COLLECTING_LICENSES, true) === false) {
            $this->context
                ->buildViolation('Le métier ne correspond à aucun connu.')
                ->setCode('c81d668b-8357-4af5-a09e-65feaa5a9952')
                ->addViolation();
        }
    }
}
