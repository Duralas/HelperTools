<?php

declare(strict_types=1);

namespace App\Validator\Validations;

use App\{
    Model\Tools\ManufacturingSummary,
    Validator\Constraints\ManufacturingLicense
};
use Symfony\Component\Validator\{
    Constraint,
    ConstraintValidator,
    Exception\UnexpectedTypeException
};

final class ManufacturingLicenseValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($constraint instanceof ManufacturingLicense === false) {
            throw new UnexpectedTypeException($constraint, ManufacturingLicense::class);
        }

        if (in_array($value, ManufacturingSummary::MANUFACTURING_LICENSES, true) === false) {
            $this->context
                ->buildViolation('Le métier ne correspond à aucun connu.')
                ->setCode('c81d668b-8357-4af5-a09e-65feaa5a9952')
                ->addViolation();
        }
    }
}
