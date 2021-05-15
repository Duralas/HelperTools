<?php

declare(strict_types=1);

namespace App\FormHandler\Tools;

use App\{
    Entity\Equipment,
    Form\Common\CraftingExperienceType,
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
        $craftingExperience = $manufacturingSummary->getCraftingExperience();

        return $this->rendering->render(
            'tools/manufacturing_report/template.html.twig',
            $this->normalizer->normalize(
                new ManufacturingReport(
                    $manufacturingSummary->getRace(),
                    $manufacturingSummary->getCharacter(),
                    $this->getEquipments($manufacturingSummary->getManufacturedEquipments()),
                    is_int($craftingExperience) ? $this->getEarnedXp($craftingExperience) : '',
                    $this->getEquipments($manufacturingSummary->getEnhancedEquipments()),
                    $this->getAdditionalReward($manufacturingSummary->getExperienceBonus(), $manufacturingSummary->getAdditionalReward()),
                    $manufacturingSummary->getComment(),
                    $this->getValidatedQuests($manufacturingSummary->getManufacturingLicense(), $manufacturingSummary->getManufacturingQuest())
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

    private function getEarnedXp(int $experience): string
    {
        return $this->translator->trans('tools.manufacturing_report.exp_reward', ['%count%' => $this->calculateEarnedXp($experience)]);
    }

    private function getAdditionalReward(?int $experienceBonus, string $additionalReward): string
    {
        $reward = '';
        if (is_int($experienceBonus)) {
            $reward = $this->getEarnedXp($experienceBonus) . ($additionalReward === '' ? '' : ' et ');
        }

        return $reward . $additionalReward;
    }

    private function calculateEarnedXp(int $experience): int
    {
        return min(CraftingExperienceType::MAX_EXPERIENCE - $experience, CraftingExperienceType::EXPERIENCE_BY_RP);
    }
}
