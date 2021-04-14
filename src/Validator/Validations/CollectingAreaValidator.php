<?php

declare(strict_types=1);

namespace App\Validator\Validations;

use App\{
    Model\Tools\CollectingSummary,
    Validator\Constraints\CollectingArea
};
use Symfony\Component\Validator\{
    Constraint,
    ConstraintValidator,
    Exception\UnexpectedTypeException
};

final class CollectingAreaValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($constraint instanceof CollectingArea === false) {
            throw new UnexpectedTypeException($constraint, CollectingArea::class);
        }

        if (in_array($value, CollectingSummary::COLLECTING_AREAS, true) === false) {
            $this->context
                ->buildViolation('La zone de récolte ne correspond à aucune connue.')
                ->setCode('d75e67b7-91b4-440c-b9ec-dd975f1de63f')
                ->addViolation();
        }
    }
}
