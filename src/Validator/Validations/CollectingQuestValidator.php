<?php

declare(strict_types=1);

namespace App\Validator\Validations;

use App\{
    Model\Tools\CollectingSummary,
    Validator\Constraints\CollectingQuest
};

final class CollectingQuestValidator extends AbstractQuestValidator
{
    protected function getConstraintFqcn(): string
    {
        return CollectingQuest::class;
    }

    protected function getQuestList(): array
    {
        return CollectingSummary::COLLECTING_QUESTS;
    }
}
