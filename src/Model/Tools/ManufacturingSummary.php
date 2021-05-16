<?php

declare(strict_types=1);

namespace App\Model\Tools;

use App\{
    Entity\Equipment,
    Helper\Tools\CraftingExperienceHelper,
    Validator\Constraints\Character,
    Validator\Constraints\CraftingExperience,
    Validator\Constraints\EarnedExperience,
    Validator\Constraints\Equipment as EquipmentAssertion,
    Validator\Constraints\LicensedForEnhancement,
    Validator\Constraints\ManufacturingLicense,
    Validator\Constraints\ManufacturingQuest,
    Validator\Constraints\Race
};
use Symfony\Component\Validator\{
    Constraints as Assert,
    ConstraintViolationInterface,
    Context\ExecutionContextInterface
};

/**
 * Modèle associé au formulaire {@see ManufacturingSummaryType} de génération du rapport de fabrication.
 */
final class ManufacturingSummary
{
    public const MANUFACTURING_QUESTS = [
        ManufacturingSummary::QUEST_APPRENTICE,
        ManufacturingSummary::QUEST_JOURNEYMAN,
        ManufacturingSummary::QUEST_EXPERT,
        ManufacturingSummary::QUEST_MASTER,
        ManufacturingSummary::QUEST_PERSEVERANT,
        ManufacturingSummary::QUEST_WORD_LIST,
        ManufacturingSummary::QUEST_WITHOUT_THEM,
    ];

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

    /** @ManufacturingLicense */
    protected string $manufacturingLicense = '';

    /** @CraftingExperience */
    protected ?int $craftingExperience = null;

    /** @var Equipment[] */
    protected array $manufacturedEquipments = [];

    /** @var Equipment[] */
    protected array $enhancedEquipments = [];

    /** @EarnedExperience */
    protected ?int $experienceBonus = null;

    protected string $additionalReward = '';

    /**
     * @ManufacturingQuest
     * @var string[]
     */
    protected ?array $manufacturingQuest = null;

    /** @Assert\NotBlank(message="Un commentaire pour aider le joueur à s'améliorer ?") */
    protected string $comment = '';

    /** @Assert\Callback */
    public function assertEquipments(ExecutionContextInterface $context): void
    {
        $violations = $context
            ->getValidator()
            ->validate(
                $this->manufacturedEquipments,
                [new EquipmentAssertion(['multiple' => true, 'manufacturingLicense' => $this->manufacturingLicense])]
            );
        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $context
                ->buildViolation($violation->getMessage())
                ->atPath('manufacturedEquipments')
                ->setCode($violation->getCode())
                ->addViolation();
        }

        $violations = $context
            ->getValidator()
            ->validate(
                $this->enhancedEquipments,
                [
                    new EquipmentAssertion(
                        ['multiple' => true, 'enhancementLicense' => $this->manufacturingLicense]
                    ),
                    new LicensedForEnhancement(
                        [
                            'craftingExperience' => is_int($this->craftingExperience)
                                ? $this->craftingExperience + ($this->experienceBonus ?? 0) +
                                CraftingExperienceHelper::calculateEarnedXpForManufacturing(
                                    $this->craftingExperience,
                                    $this->manufacturedEquipments
                                )
                                : null
                        ]
                    ),
                ]
            );
        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $context
                ->buildViolation($violation->getMessage())
                ->atPath('enhancedEquipments')
                ->setCode($violation->getCode())
                ->addViolation();
        }

        if (count($this->manufacturedEquipments) === 0 && count($this->enhancedEquipments) === 0) {
            $context
                ->buildViolation('Le rapport ne concerne ni manufacture ni amélioration.')
                ->atPath('manufacturedEquipments')
                ->setCode('76138508-0f1f-4f12-8230-5e58dc348da5')
                ->addViolation();
            $context
                ->buildViolation('Le rapport ne concerne ni manufacture ni amélioration.')
                ->atPath('enhancedEquipments')
                ->setCode('53375e00-8646-4a11-bdfa-585f5ddcdbfa')
                ->addViolation();
        }
    }

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

    public function getManufacturingLicense(): string
    {
        return $this->manufacturingLicense;
    }

    public function setManufacturingLicense(string $manufacturingLicense): self
    {
        $this->manufacturingLicense = $manufacturingLicense;

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

    /** @return Equipment[] */
    public function getManufacturedEquipments(): array
    {
        return $this->manufacturedEquipments;
    }

    /** @param Equipment[] $manufacturedEquipments */
    public function setManufacturedEquipments(array $manufacturedEquipments): self
    {
        $this->manufacturedEquipments = $manufacturedEquipments;

        return $this;
    }

    /** @return Equipment[] */
    public function getEnhancedEquipments(): array
    {
        return $this->enhancedEquipments;
    }

    /** @param Equipment[] $enhancedEquipments */
    public function setEnhancedEquipments(array $enhancedEquipments): self
    {
        $this->enhancedEquipments = $enhancedEquipments;

        return $this;
    }

    public function getExperienceBonus(): ?int
    {
        return $this->experienceBonus;
    }

    public function setExperienceBonus(?int $experienceBonus): self
    {
        $this->experienceBonus = $experienceBonus;

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
    public function getManufacturingQuest(): ?array
    {
        return $this->manufacturingQuest;
    }

    /** @param string[] $manufacturingQuest */
    public function setManufacturingQuest(?array $manufacturingQuest): self
    {
        $this->manufacturingQuest = $manufacturingQuest;

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

    public function isManufacturing(): bool
    {
        return count($this->manufacturedEquipments) > 0;
    }

    public function isEnhancement(): bool
    {
        return count($this->enhancedEquipments) > 0;
    }
}
