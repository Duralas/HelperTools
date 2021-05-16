<?php

declare(strict_types=1);

namespace App\Helper\Tools;

use App\{
    Entity\Equipment,
    Form\Common\CraftingExperienceType,
    Model\Tools\CollectingSummary
};

final class CraftingExperienceHelper
{
    public static function calculateEarnedXp(int $experience, int $earnedExperience): int
    {
        return min(CraftingExperienceType::MAX_EXPERIENCE - $experience, $earnedExperience);
    }

    public static function calculateEarnedXpForCollecting(int $experience, string $collectingArea): int
    {
        $earnedXp = min(CraftingExperienceType::MAX_EXPERIENCE - $experience, CraftingExperienceType::EXPERIENCE_BY_RP);
        if (CraftingExperienceType::MAX_EXPERIENCE - $experience <= CraftingExperienceType::EXPERIENCE_BY_RP && $collectingArea !== CollectingSummary::COLLECTING_AREA_MASTER) {
            $earnedXp = max(0, $earnedXp - 1);
        }

        return $earnedXp;
    }

    /** @param Equipment[] $equipments */
    public static function calculateEarnedXpForManufacturing(int $experience, array $equipments): int
    {
        return static::calculateEarnedXp(
            $experience,
            CraftingExperienceType::EXPERIENCE_BY_RP * count($equipments)
        );
    }
}
