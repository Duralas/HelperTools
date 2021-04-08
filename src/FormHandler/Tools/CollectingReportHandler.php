<?php

declare(strict_types=1);

namespace App\FormHandler\Tools;

use App\{
    Form\Common\LicenseExperienceType,
    Model\Common\Quest,
    Model\Tools\CollectingReport,
    Model\Tools\CollectingSummary};
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
                    $collectingSummary->getComment(),
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
        $earnedXp = min(LicenseExperienceType::MAX_EXPERIENCE - $experience, 5);
        if (LicenseExperienceType::MAX_EXPERIENCE - $experience <= 5 && $collectingArea !== 'master') {
            $earnedXp = max(0, $earnedXp - 1);
        }

        return $this->translator->trans('tools.collecting_report.exp_reward', ['%count%' => $earnedXp]);
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
}
