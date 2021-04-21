<?php

declare(strict_types=1);

namespace App\Validator\Validations;

use Symfony\Component\Validator\{
    Constraint,
    ConstraintValidator,
    Exception\UnexpectedTypeException,
    Exception\UnexpectedValueException
};

abstract class AbstractQuestValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (is_a($constraint, $this->getConstraintFqcn()) === false) {
            throw new UnexpectedTypeException($constraint, $this->getConstraintFqcn());
        }

        if ($value === null) {
            return;
        }

        if (is_array($value) === false) {
            throw new UnexpectedValueException($value, 'string[]');
        }

        foreach ($value as $quest) {
            if (in_array($quest, $this->getQuestList(), true) === false) {
                $this->context
                    ->buildViolation("La quête ne correspond à aucune connue.")
                    ->setCode('11669e06-47ee-4a8b-99ee-928b09d09f7a')
                    ->addViolation();

                break;
            }
        }
    }

    abstract protected function getConstraintFqcn(): string;

    /** @return string[] */
    abstract protected function getQuestList(): array;
}
