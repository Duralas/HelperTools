<?php


namespace App\FormHandler\Tools;

use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * Service de gestion du formulaire pour la génération du `collecting_report`.
 */
class CollectingReportHandler
{
    /**
     * Constante pour le métier de récolte "bûcheron".
     */
    public const LICENSE_LOGGER = 'logger';
    /**
     * Constante pour le métier de récolte "chasseur".
     */
    public const LICENSE_HUNTER = 'hunter';
    /**
     * Constante pour le métier de récolte "mineur".
     */
    public const LICENSE_MINER  = 'miner';

    /** @var Environment */
    private $rendering;
    /** @var TranslatorInterface */
    private $translator;

    /**
     * CollectingReportHandler constructor.
     *
     * @param Environment $rendering
     */
    public function __construct(Environment $rendering, TranslatorInterface $translator)
    {
        $this->rendering = $rendering;
        $this->translator = $translator;
    }

    public function generate($formData): string
    {
        $templateData = $this->extractTemplateData($formData);

        return $this->render($templateData);
    }

    private function extractTemplateData(array $formData): array
    {
        // Récupération des données de base
        $license        = $formData['collecting_license'];
        $experience     = $formData['crafting_experience'];
        $collectingArea = $formData['collecting_area'];

        // Construction des données
        $templateData = [
            'race'                  => $formData['race'],
            'character'             => $formData['character'],
            'collecting_loots'      => $this->getLootsInArea($license, $collectingArea, $experience),
//            'collecting_experience' => $this->getEarnedXp($experience, $collectingArea),
            'additional_reward'     => $formData['additional_reward'],
            'comment'               => $formData['comment'],
        ];

        // Gestion des points métier
        $diffToMax = 200 - $experience;
        $earnedXp  = min($diffToMax, 5);
        if ($diffToMax <= 5 && $formData['collecting_area'] !== 'master') {
            $earnedXp = max(0, $earnedXp - 1);
        }
        if ($earnedXp <= 0) {
            $collectingExpReward = '';
        } else {
            $collectingExpReward = " et $earnedXp " . ($earnedXp > 1 ? 'points métier' : 'point métier');
        }
        $templateData['collecting_experience'] = $collectingExpReward;

        // Gestion des quêtes
        $validatedQuests = [];
        foreach ($formData['collecting_quest'] as $quest => $questLabel) {
            switch($quest) {
                case 'apprentice':
                    $questLogger = "x5 Bois de cerisier et 10 points d'expérience";
                    $questHunter = "x1 Plume d'aigle et 10 points d'expérience";
                    $questMiner  = "x5 Minerai de cuivre et 10 points d'expérience";
                    break;
                case 'journeyman':
                    $questLogger = "x6 Bois de sapin, x2 Bois de sureau et 20 points d'expérience";
                    $questHunter = "x1 Écaille de crocodile, x1 Cuir de sanglier et 20 points d'expérience";
                    $questMiner  = "x6 Minerai d'argent, x2 Minerai de fer et 20 points d'expérience";
                    break;
                case 'expert':
                    $questLogger = "x7 Bois de chêne, x2 Bois de sureau et 30 points d'expérience";
                    $questHunter = "x1 Peau cuirassée, x2 Défense de sanglier et 30 points d'expérience";
                    $questMiner  = "x7 Minerai d'or, x2 Minerai de fer et 30 points d'expérience";
                    break;
                case 'master':
                    $questLogger = "x10 Bois de baobab et 40 points d'expérience";
                    $questHunter = "x2 Écailles de wyverne et 40 points d'expérience";
                    $questMiner  = "x10 Minerai de diamant et 40 points d'expérience";
                    break;
                case 'perseverant':
                    $questLogger = $questHunter = $questMiner  = "x1 Peau de troll des marais, x1 Peau de troll des glaces, x1 Peau des troll des forêts, x1 Peau de troll des montagnes, x1 Défense de pachyderme et 40 points d'expérience";
                    break;
                case 'word_list':
                    $questLogger = $questHunter = $questMiner  = "500 pièces d'or";
                    break;
                case 'without_them':
                    $questLogger = $questHunter = $questMiner  = "x2 Potion d'hypersensibilité (+50% effets négatifs) et x2 Potion d'insensibilité (annulation des effets négatifs)";
                    break;
                default:
                    $questLogger = $questHunter = $questMiner = '⚠ Aucune correspondance dans l\'outil';
            }
            $rewardFormatter = [
                'logger' => $questLogger,
                'hunter' => $questHunter,
                'miner'  => $questMiner,
            ];
            $validatedQuests[] = [
                'name'    => $questLabel,
                'rewards' => $this->translator->trans("{{$license}}", $rewardFormatter),
            ];
        }
        $templateData['validated_quests'] = $validatedQuests;

        return $templateData;
    }

    private function render(array $templateData): string
    {
        return $this->rendering->render('tools/collecting_report/template.html.twig', $templateData);
    }

    //region -- Méthodes sur les métiers

    private function getLootsInArea(string $license, string $collectingArea, int $experience): string
    {

        switch ($collectingArea) {
            case 'novice':
                $collectLogger = "
                {experience, plural,
                    200   {x25 Bois de sureau}
                    <= 10 {x5 Bois de sureau}
                    <= 20 {x10 Bois de sureau}
                    <= 30 {x15 Bois de sureau}
                    other {x20 Bois de sureau} 
                }
                ";
                $collectHunter = "
                {experience, plural,
                    200   {x2 Défense de sanglier, x2 Cuir de sanglier}
                    <= 10 {x1 Défense de sanglier}
                    <= 20 {x2 Défense de sanglier}
                    <= 30 {x2 Défense de sanglier, x1 Cuir de sanglier}
                    other {x2 Défense de sanglier, x2 Cuir de sanglier} 
                }
                ";
                $collectMiner  = "
                {experience, plural,
                    200   {x25 Minerai de fer}
                    <= 10 {x5 Minerai de fer}
                    <= 20 {x10 Minerai de fer}
                    <= 30 {x15 Minerai de fer}
                    other {x20 Minerai de fer} 
                }
                ";
                break;
            case 'apprentice':
                $collectLogger = "
                {experience, plural,
                    200   {x25 Bois de cerisier}
                    <= 40 {}
                    <= 50 {x5 Bois de cerisier}
                    <= 60 {x10 Bois de cerisier}
                    <= 70 {x15 Bois de cerisier}
                    other {x20 Bois de cerisier} 
                }
                ";
                $collectHunter = "
                {experience, plural,
                    200   {x2 Plume d'aigle, x1 Bec d'aigle, x1 Serre d'aigle}
                    <= 40 {}
                    <= 50 {x1 Plume d'aigle}
                    <= 60 {x2 Plume d'aigle}
                    <= 70 {x2 Plume d'aigle, x1 Bec d'aigle}
                    other {x2 Plume d'aigle, x1 Bec d'aigle, x1 Serre d'aigle}
                }
                ";
                $collectMiner  = "
                {experience, plural,
                    200   {x25 Minerai de cuivre}
                    <= 40 {}
                    <= 50 {x5 Minerai de cuivre}
                    <= 60 {x10 Minerai de cuivre}
                    <= 70 {x15 Minerai de cuivre}
                    other {x20 Minerai de cuivre} 
                }
                ";
                break;
            case 'journeyman':
                $collectLogger = "
                {experience, plural,
                    200   {x25 Bois de sapin}
                    <= 80 {}
                    <= 90 {x5 Bois de sapin}
                    <= 100 {x10 Bois de sapin}
                    <= 110 {x15 Bois de sapin}
                    other {x20 Bois de sapin} 
                }
                ";
                $collectHunter = "
                {experience, plural,
                    200   {x2 Écaille de crocodile, x1 Cuir de crocodile, x1 Dent de crocodile}
                    <= 80 {}
                    <= 90 {x1 Écaille de crocodile}
                    <= 100 {x2 Écaille de crocodile}
                    <= 110 {x2 Écaille de crocodile, x1 Cuir de crocodile}
                    other {x2 Écaille de crocodile, x1 Cuir de crocodile, x1 Dent de crocodile} 
                }
                ";
                $collectMiner  = "
                {experience, plural,
                    200   {x25 Minerai d'argent}
                    <= 80 {}
                    <= 90 {x5 Minerai d'argent}
                    <= 100 {x10 Minerai d'argent}
                    <= 110 {x15 Minerai d'argent}
                    other {x20 Minerai d'argent} 
                }
                ";
                break;
            case 'expert':
                $collectLogger = "
                {experience, plural,
                    200   {x25 Bois de chêne}
                    <= 120 {}
                    <= 130 {x5 Bois de chêne}
                    <= 140 {x10 Bois de chêne}
                    <= 150 {x15 Bois de chêne}
                    other {x20 Bois de chêne} 
                }
                ";
                $collectHunter = "
                {experience, plural,
                    200   {x2 Corne de rhinocéros, x2 Peau renforcée}
                    <= 120 {}
                    <= 130 {x1 Corne de rhinocéros}
                    <= 140 {x2 Corne de rhinocéros}
                    <= 150 {x2 Corne de rhinocéros, x1 Peau renforcée}
                    other {x2 Corne de rhinocéros, x2 Peau renforcée} 
                }
                ";
                $collectMiner  = "
                {experience, plural,
                    200   {x25 Minerai d'or}
                    <= 120 {}
                    <= 130 {x5 Minerai d'or}
                    <= 140 {x10 Minerai d'or}
                    <= 150 {x15 Minerai d'or}
                    other {x20 Minerai d'or} 
                }
                ";
                break;
            case 'master':
                $collectLogger = "
                {experience, plural,
                    200   {x25 Bois de baobab}
                    <= 160 {}
                    <= 170 {x5 Bois de baobab}
                    <= 180 {x10 Bois de baobab}
                    <= 190 {x15 Bois de baobab}
                    other {x20 Bois de baobab} 
                }
                ";
                $collectHunter = "
                {experience, plural,
                    200   {x2 Écaille de wyverne, x1 Membrane de wyverne, x1 Tibia de wyverne}
                    <= 160 {}
                    <= 170 {x1 Écaille de wyverne}
                    <= 180 {x2 Écaille de wyverne}
                    <= 190 {x2 Écaille de wyverne, x1 Membrane de wyverne}
                    other {x2 Écaille de wyverne, x1 Membrane de wyverne, x1 Tibia de wyverne} 
                }
                ";
                $collectMiner  = "
                {experience, plural,
                    200   {x25 Minerai de diamant}
                    <= 160 {}
                    <= 170 {x5 Minerai de diamant}
                    <= 180 {x10 Minerai de diamant}
                    <= 190 {x15 Minerai de diamant}
                    other {x20 Minerai de diamant} 
                }
                ";
                break;
            case 'djollfulin-bamboo':
                $collectMiner  = $collectHunter = 'x5 Bambou';
                $collectLogger = "
                {experience, plural,
                    200    {x20 Bambou, x5 Bois de sureau, x5 Minerai de cerisier}
                    >= 185 {x10 Bambou, x5 Bois de sureau, x5 Minerai de cerisier}
                    >= 175 {x5 Bambou, x5 Bois de sureau}
                    other  {x5 Bambou}
                }
                ";
                break;
            case 'djollfulin-tamehagane':
                $collectLogger = $collectHunter = 'x5 Minerai de tamahagane';
                $collectMiner  = "
                {experience, plural,
                    200    {x20 Minerai de tamahagane, x5 Minerai de fer, x5 Minerai de cuivre}
                    >= 185 {x10 Minerai de tamahagane, x5 Minerai de fer, x5 Minerai de cuivre}
                    >= 175 {x5 Minerai de tamahagane, x5 Minerai de fer}
                    other  {x5 Minerai de tamahagane}
                }
                ";
                break;
            default:
                $collectLogger = $collectHunter = $collectMiner = "⚠ $collectingArea non prévu par l'outil";
        }

        $collect = $this->translator->trans("{{$license}}", [
            self::LICENSE_LOGGER => $collectLogger,
            self::LICENSE_HUNTER => $collectHunter,
            self::LICENSE_MINER  => $collectMiner,
        ]);

        return $this->translator->trans($collect, ['experience' => $experience]);
    }

    //endregion Méthodes sur les métiers

}
