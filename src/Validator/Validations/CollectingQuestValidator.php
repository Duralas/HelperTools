<?php

declare(strict_types=1);

namespace App\Validator\Validations;

use App\{
    Model\Tools\CollectingSummary,
    Validator\Constraints\CollectingQuest
};
use Symfony\Component\Validator\{
    Constraint,
    ConstraintValidator,
    Exception\UnexpectedTypeException,
    Exception\UnexpectedValueException
};

final class CollectingQuestValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($constraint instanceof CollectingQuest === false) {
            throw new UnexpectedTypeException($constraint, CollectingQuest::class);
        }

        if ($value === null) {
            return;
        }

        if (is_array($value) === false) {
            throw new UnexpectedValueException($value, 'string[]');
        }

        foreach ($value as $quest) {
            if (in_array($quest, CollectingSummary::COLLECTING_QUESTS, true) === false) {
                $this->context
                    ->buildViolation("La quête ne correspond à aucune connue.")
                    ->setCode('11669e06-47ee-4a8b-99ee-928b09d09f7a')
                    ->addViolation();

                break;
            }
        }
    }
}
