<?php

declare(strict_types=1);

namespace App\FormHandler\Tools;

use App\{
    Form\Common\LicenseExperienceType,
    Model\Common\Quest,
    Model\Tools\CollectingReport,
    Model\Tools\CollectingSummary
};
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * Service de gestion du formulaire pour la génération du `collecting_report`.
 */
final class CollectingReportHandler
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

    public function generateTemplate(CollectingSummary $collectingSummary): string
    {
        return $this->rendering->render(
            'tools/collecting_report/template.html.twig',
            $this->normalizer->normalize(
                new CollectingReport(
                    $collectingSummary->getRace(),
                    $collectingSummary->getCharacter(),
                    $this->getLootsInArea($collectingSummary->getCollectingLicense(), $collectingSummary->getCollectingArea(), $collectingSummary->getLicenseExperience()),
                    $this->getEarnedXp($collectingSummary->getLicenseExperience(), $collectingSummary->getCollectingArea()),
                    $collectingSummary->getAdditionalReward(),
                    $this->completeComment($collectingSummary->getComment(), $collectingSummary->getLicenseExperience(), $collectingSummary->getCollectingArea(), $collectingSummary->getAdditionalReward()),
                    $this->getValidatedQuests($collectingSummary->getCollectingLicense(), $collectingSummary->getCollectingQuest())
                )
            )
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
            $questTranslationKey = "tools.collecting_report.quest.{$license}.{$quest}";
            $questReward = $this->translator->trans($questTranslationKey);
            if ($questReward === $questTranslationKey) {
                $questReward = "⚠ Quête $questLabel non prévue";
            }

            $validatedQuests[] = new Quest($questLabel, $questReward);
        }

        return $validatedQuests;
    }

    private function getEarnedXp(int $experience, string $collectingArea): string
    {
        return $this->translator->trans('tools.collecting_report.exp_reward', ['%count%' => $this->calculateEarnedXp($experience, $collectingArea)]);
    }

    private function getLootsInArea(string $license, string $collectingArea, int $experience): string
    {
        $collectTranslationKey = "tools.collecting_report.{$license}.{$collectingArea}";
        $collectMessage = $this->translator->trans($collectTranslationKey, ['%count%' => $experience]);
        if ($collectMessage === $collectTranslationKey) {
            $collectMessage = "⚠ Zone {$collectingArea} non prévue";
        }

        return $collectMessage;
    }

    private function completeComment(string $comment, int $experience, string $collectingArea, string $additionalReward): string
    {
        $earnedXp = $this->calculateEarnedXp($experience, $collectingArea);

        if ($earnedXp === 0) {
            return $comment;
        }

        // Vérification des points métier en récompense additionnelle
        if ($earnedXp >= LicenseExperienceType::EXPERIENCE_BY_RP && stripos($additionalReward, 'points métier') !== false) {
            preg_match('/(?<xp>\d+) points métier/u', $additionalReward, $matches);
            if (array_key_exists('xp', $matches)) {
                $earnedXp += (int) $matches['xp'];
            }
        }

        $licenseRequirements = [
            LicenseExperienceType::LICENSE_RANK_APPRENTICE => LicenseExperienceType::MIN_REQUIREMENT_APPRENTICE,
            LicenseExperienceType::LICENSE_RANK_JOURNEYMAN => LicenseExperienceType::MIN_REQUIREMENT_JOURNEYMAN,
            LicenseExperienceType::LICENSE_RANK_EXPERT => LicenseExperienceType::MIN_REQUIREMENT_EXPERT,
            LicenseExperienceType::LICENSE_RANK_MASTER => LicenseExperienceType::MIN_REQUIREMENT_MASTER,
            LicenseExperienceType::LICENSE_RANK_ABSOLUTE_MASTER => LicenseExperienceType::MIN_REQUIREMENT_ABSOLUTE_MASTER,
        ];
        foreach ($licenseRequirements as $license => $requirement) {
            if ($experience < $requirement && $experience + $earnedXp >= $requirement) {
                $comment = $this->translator->trans("tools.collecting_report.comment.ranking_up.{$license}") . "\n{$comment}";

                break;
            }
        }

        return $comment;
    }

    private function calculateEarnedXp(int $experience, string $collectingArea): int
    {
        $earnedXp = min(LicenseExperienceType::MAX_EXPERIENCE - $experience, LicenseExperienceType::EXPERIENCE_BY_RP);
        if (LicenseExperienceType::MAX_EXPERIENCE - $experience <= LicenseExperienceType::EXPERIENCE_BY_RP && $collectingArea !== CollectingSummary::COLLECTING_AREA_MASTER) {
            $earnedXp = max(0, $earnedXp - 1);
        }

        return $earnedXp;
    }
}
