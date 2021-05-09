<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\Validations\ManufacturingLicenseValidator;
use Symfony\Component\Validator\Constraint;

/** @Annotation  */
final class ManufacturingLicense extends Constraint
{
    public function validatedBy(): string
    {
        return ManufacturingLicenseValidator::class;
    }

}
