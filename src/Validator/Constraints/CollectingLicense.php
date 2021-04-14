<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\Validations\CollectingLicenseValidator;
use Symfony\Component\Validator\Constraint;

/** @Annotation  */
final class CollectingLicense extends Constraint
{
    public function validatedBy(): string
    {
        return CollectingLicenseValidator::class;
    }

}
