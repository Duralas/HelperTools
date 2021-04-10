<?php

declare(strict_types=1);

namespace App\Model\Tools;

use App\{
    Form\Common\LicenseExperienceType,
    Form\Common\RaceType
};
use Symfony\Component\Validator\Constraints as Assert;

final class CollectingSummary
{
    public const COLLECTING_AREAS = [
        'novice',
        'apprentice',
        'journeyman',
        'expert',
        'master',
        'djollfulin-bamboo',
        'djollfulin-tamehagane',
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

    public const QUEST_APPRENTICE = 'apprentice';
    public const QUEST_JOURNEYMAN = 'journeyman';
    public const QUEST_EXPERT = 'expert';
    public const QUEST_MASTER = 'master';
    public const QUEST_PERSEVERANT = 'perseverant';
    public const QUEST_WORD_LIST = 'word_list';
    public const QUEST_WITHOUT_THEM = 'without_them';
    
    /** @Assert\NotBlank(message="Le nom du personnage est obligatoire.") */
    protected string $character = '';

    /** @Assert\Choice(choices=RaceType::RACE_CHOICES, message="La race ne correspond à aucune jouable.") */
    protected string $race = '';

    /** @Assert\Choice(choices=CollectingSummary::COLLECTING_LICENSES, message="Le métier ne correspond à aucun connu.")*/
    protected string $collectingLicense = '';

    /**
     * @Assert\PositiveOrZero(message="L'expérience métier ne peut être une valeur négative.")
     * @Assert\LessThanOrEqual(value=LicenseExperienceType::MAX_EXPERIENCE, message="Il n'est pas possible de dépasser la valeur {{ compared_value }}.")
     */
    protected int $licenseExperience = 0;

    /** @Assert\Choice(choices=CollectingSummary::COLLECTING_AREAS, message="La zone de récolte ne correspond à aucune connue.") */
    protected string $collectingArea = '';

    protected string $additionalReward = '';

    /**
     * @Assert\Choice(multiple=true, choices=CollectingSummary::COLLECTING_QUESTS, message="La quête ne correspond à aucune connue.")
     * @var string[]
     */
    protected ?array $collectingQuest = null;

    /** @Assert\NotBlank(message="Un commentaire pour aider le *rôle player* à s'améliorer ?") */
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

    public function getLicenseExperience(): int
    {
        return $this->licenseExperience;
    }

    public function setLicenseExperience(int $licenseExperience): self
    {
        $this->licenseExperience = $licenseExperience;

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
