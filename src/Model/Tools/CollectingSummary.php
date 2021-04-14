<?php

declare(strict_types=1);

namespace App\Model\Tools;

use App\{
    Validator\Constraints\Character,
    Validator\Constraints\CollectingArea,
    Validator\Constraints\CollectingLicense,
    Validator\Constraints\CollectingQuest,
    Validator\Constraints\CraftingExperience,
    Validator\Constraints\Race
};
use Symfony\Component\Validator\Constraints as Assert;

final class CollectingSummary
{
    public const COLLECTING_AREAS = [
        CollectingSummary::COLLECTING_AREA_NOVICE,
        CollectingSummary::COLLECTING_AREA_APPRENTICE,
        CollectingSummary::COLLECTING_AREA_JOURNEYMAN,
        CollectingSummary::COLLECTING_AREA_EXPERT,
        CollectingSummary::COLLECTING_AREA_MASTER,
        CollectingSummary::COLLECTING_AREA_DJOLLFULIN_BAMBOO,
        CollectingSummary::COLLECTING_AREA_DJOLLFULIN_TAMEHAGANE,
    ];
    public const COLLECTING_LICENSES = [
        'hunter',
        'logger',
        'miner',
    ];
    public const COLLECTING_QUESTS = [
        CollectingSummary::QUEST_APPRENTICE,
        CollectingSummary::QUEST_JOURNEYMAN,
        CollectingSummary::QUEST_EXPERT,
        CollectingSummary::QUEST_MASTER,
        CollectingSummary::QUEST_PERSEVERANT,
        CollectingSummary::QUEST_WORD_LIST,
        CollectingSummary::QUEST_WITHOUT_THEM,
    ];

    public const COLLECTING_AREA_NOVICE = 'novice';
    public const COLLECTING_AREA_APPRENTICE = 'apprentice';
    public const COLLECTING_AREA_JOURNEYMAN = 'journeyman';
    public const COLLECTING_AREA_EXPERT = 'expert';
    public const COLLECTING_AREA_MASTER = 'master';
    public const COLLECTING_AREA_DJOLLFULIN_BAMBOO = 'djollfulin-bamboo';
    public const COLLECTING_AREA_DJOLLFULIN_TAMEHAGANE = 'djollfulin-tamehagane';

    public const QUEST_APPRENTICE = 'apprentice';
    public const QUEST_JOURNEYMAN = 'journeyman';
    public const QUEST_EXPERT = 'expert';
    public const QUEST_MASTER = 'master';
    public const QUEST_PERSEVERANT = 'perseverant';
    public const QUEST_WORD_LIST = 'word_list';
    public const QUEST_WITHOUT_THEM = 'without_them';

    /** @Character */
    protected string $character = '';

    /** @Race */
    protected string $race = '';

    /** @CollectingLicense */
    protected string $collectingLicense = '';

    /** @CraftingExperience */
    protected ?int $craftingExperience = null;

    /** @CollectingArea */
    protected string $collectingArea = '';

    protected string $additionalReward = '';

    /**
     * @CollectingQuest
     * @var string[]
     */
    protected ?array $collectingQuest = null;

    /** @Assert\NotBlank(message="Un commentaire pour aider le joueur à s'améliorer ?") */
    protected string $comment = '';

    public function getCharacter(): string
    {
        return $this->character;
    }

    public function setCharacter(string $character): self
    {
        $this->character = $character;

        return $this;
    }

    public function getRace(): string
    {
        return $this->race;
    }

    public function setRace(string $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getCollectingLicense(): string
    {
        return $this->collectingLicense;
    }

    public function setCollectingLicense(string $collectingLicense): self
    {
        $this->collectingLicense = $collectingLicense;

        return $this;
    }

    public function getCraftingExperience(): ?int
    {
        return $this->craftingExperience;
    }

    public function setCraftingExperience(?int $craftingExperience): self
    {
        $this->craftingExperience = $craftingExperience;

        return $this;
    }

    public function getCollectingArea(): string
    {
        return $this->collectingArea;
    }

    public function setCollectingArea(string $collectingArea): self
    {
        $this->collectingArea = $collectingArea;

        return $this;
    }

    public function getAdditionalReward(): string
    {
        return $this->additionalReward;
    }

    public function setAdditionalReward(string $additionalReward): self
    {
        $this->additionalReward = $additionalReward;

        return $this;
    }

    /** @return string[] */
    public function getCollectingQuest(): array
    {
        return $this->collectingQuest;
    }

    /** @param string[] $collectingQuest */
    public function setCollectingQuest(?array $collectingQuest): self
    {
        $this->collectingQuest = $collectingQuest;

        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
