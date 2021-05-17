<?php

declare(strict_types=1);

namespace App\FormHandler\Tools;

use App\{
    Entity\Equipment,
    Entity\Recipe,
    Form\Common\CraftingExperienceType,
    Helper\Tools\CraftingExperienceHelper,
    Model\Common\Quest,
    Model\Tools\ManufacturingReport,
    Model\Tools\ManufacturingSummary
};
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * Service de gestion du formulaire pour la génération du `manufacturing_report`.
 */
final class ManufacturingReportHandler
{
    protected Environment $rendering;

    protected TranslatorInterface $translator;

    protected NormalizerInterface $normalizer;

    public function __construct(Environment $rendering, TranslatorInterface $translator, NormalizerInterface $normalizer)
    {
        $this->rendering = $rendering;
        $this->translator = $translator;
        $this->normalizer = $normalizer;
    }

    public function generateTemplate(ManufacturingSummary $manufacturingSummary): string
    {
        $currentEarnedExperience = is_int($manufacturingSummary->getCraftingExperience())
            ? CraftingExperienceHelper::calculateEarnedXpForManufacturing(
                $manufacturingSummary->getCraftingExperience(),
                $manufacturingSummary->getManufacturedEquipments()
            )
            : 0;

        return $this->rendering->render(
            'tools/manufacturing_report/template.html.twig',
            $this->normalizer->normalize(
                new ManufacturingReport(
                    $manufacturingSummary->getRace(),
                    $manufacturingSummary->getCharacter(),
                    $this->getEquipments($manufacturingSummary->getManufacturedEquipments()),
                    is_int($manufacturingSummary->getCraftingExperience())
                        ? $this->getEarnedXp($currentEarnedExperience)
                        : '',
                    $this->getEquipments($manufacturingSummary->getEnhancedEquipments()),
                    $this->getAdditionalReward(
                        $manufacturingSummary->getExperienceBonus(),
                        is_int($manufacturingSummary->getCraftingExperience())
                            ? $manufacturingSummary->getCraftingExperience() + $currentEarnedExperience
                            : 0,
                        $manufacturingSummary->getAdditionalReward()
                    ),
                    is_int($manufacturingSummary->getCraftingExperience())
                        ? $this->completeComment(
                            $manufacturingSummary->getComment(),
                            $manufacturingSummary->getCraftingExperience(),
                        $manufacturingSummary->getCraftingExperience() + $currentEarnedExperience,
                        $manufacturingSummary->getExperienceBonus() ?? 0
                        )
                        : $manufacturingSummary->getComment(),
                    $this->getValidatedQuests(
                        $manufacturingSummary->getManufacturingLicense(),
                        $manufacturingSummary->getManufacturingQuest()
                    ),
                    $this->getRecipes($manufacturingSummary->getManufacturedEquipments())
                )
            )
        );
    }

    /** @param Equipment[] $equipments */
    private function getEquipments(array $equipments): string
    {
        return implode(
            ', ',
            array_map(static fn (Equipment $equipment) => $equipment->getName(), $equipments)
        );
    }

    /**
     * @param array<string> $quests
     * @return Quest[]
     */
    private function getValidatedQuests(string $license, array $quests): array
    {
        // Gestion des quêtes
        $validatedQuests = [];
        foreach ($quests as $quest) {
            $questLabel = $this->translator->trans("quest.licensing.{$quest}", [], 'rules');
            $questTranslationKey = "tools.manufacturing_report.quest.{$license}.{$quest}";
            $questReward = $this->translator->trans($questTranslationKey);
            if ($questReward === $questTranslationKey) {
                $questReward = "⚠ Quête $questLabel non prévue";
            }

            $validatedQuests[] = new Quest($questLabel, $questReward);
        }

        return $validatedQuests;
    }

    private function getEarnedXp(int $earnedXp): string
    {
        return $this->translator->trans('tools.manufacturing_report.exp_reward', ['%count%' => $earnedXp]);
    }

    private function getAdditionalReward(
        ?int $experienceBonus,
        int $currentExperience,
        string $additionalReward
    ): string {
        $reward = '';
        if (is_int($experienceBonus)) {
            $reward = $this->getEarnedXp(
                CraftingExperienceHelper::calculateEarnedXp($currentExperience, $experienceBonus)
                ) . ($additionalReward === '' ? '' : ' et ');
        }

        return $reward . $additionalReward;
    }

    private function completeComment(
        string $comment,
        int $baseExperience,
        int $currentExperience,
        int $experienceBonus
    ): string {
        $earnedXp = CraftingExperienceHelper::calculateEarnedXp($currentExperience, $experienceBonus);
        if ($earnedXp === 0 && $currentExperience - $baseExperience === 0) {
            return $comment;
        }

        $licenseRequirements = [
            CraftingExperienceType::LICENSE_RANK_APPRENTICE => CraftingExperienceType::MIN_REQUIREMENT_APPRENTICE,
            CraftingExperienceType::LICENSE_RANK_JOURNEYMAN => CraftingExperienceType::MIN_REQUIREMENT_JOURNEYMAN,
            CraftingExperienceType::LICENSE_RANK_EXPERT => CraftingExperienceType::MIN_REQUIREMENT_EXPERT,
            CraftingExperienceType::LICENSE_RANK_MASTER => CraftingExperienceType::MIN_REQUIREMENT_MASTER,
            CraftingExperienceType::LICENSE_RANK_ABSOLUTE_MASTER => CraftingExperienceType::MIN_REQUIREMENT_ABSOLUTE_MASTER,
        ];
        $comments = [$comment];
        foreach ($licenseRequirements as $license => $requirement) {
            if ($baseExperience < $requirement && $currentExperience + $earnedXp >= $requirement) {
                $comments[] = $this->translator->trans("tools.manufacturing_report.comment.ranking_up.{$license}");
            }
        }

        return implode("\n", $comments);
    }

    /**
     * @param Equipment[] $manufacturedEquipments
     * @return Recipe[]
     */
    private function getRecipes(array $manufacturedEquipments): array
    {
        return array_map(
            static fn (Equipment $manufacturedEquipment) => $manufacturedEquipment->getRecipe(),
            $manufacturedEquipments
        );
    }
}
