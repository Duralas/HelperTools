<?php

declare(strict_types=1);

namespace App\Validator\Validations;

use App\{
    Model\Tools\ManufacturingSummary,
    Validator\Constraints\ManufacturingQuest
};

final class ManufacturingQuestValidator extends AbstractQuestValidator
{
    protected function getConstraintFqcn(): string
    {
        return ManufacturingQuest::class;
    }

    protected function getQuestList(): array
    {
        return ManufacturingSummary::MANUFACTURING_QUESTS;
    }
}
