<?php

declare(strict_types=1);

namespace App\Model\Tools;

use App\{
    Entity\Recipe,
    Model\Common\Quest
};
use Symfony\Component\Serializer\Annotation\SerializedName;

final class ManufacturingReport
{
    protected string $race = '';

    protected string $character = '';

    protected string $crafts;

    /** @SerializedName("crafting_experience") */
    protected string $craftingExperience;

    protected string $refinements;

    /** @SerializedName("additional_reward") */
    protected string $additionalReward;

    protected string $comment;

    /**
     * @SerializedName("validated_quests")
     * @var Quest[]
     */
    protected array $validatedQuests;

    /** @var Recipe[] */
    protected array $recipes;

    /**
     * @param Quest[] $validatedQuests
     * @param Recipe[] $recipes
     */
    public function __construct(
        string $race,
        string $character,
        string $crafts,
        string $craftingExperience,
        string $refinements,
        string $additionalReward,
        string $comment,
        array $validatedQuests,
        array $recipes
    ) {
        $this->race = $race;
        $this->character = $character;
        $this->crafts = $crafts;
        $this->craftingExperience = $craftingExperience;
        $this->refinements = $refinements;
        $this->additionalReward = $additionalReward;
        $this->comment = $comment;
        $this->validatedQuests = $validatedQuests;
        $this->recipes = $recipes;
    }

    public function getRace(): string
    {
        return $this->race;
    }

    public function getCharacter(): string
    {
        return $this->character;
    }

    public function getCrafts(): string
    {
        return $this->crafts;
    }

    public function getCraftingExperience(): string
    {
        return $this->craftingExperience;
    }

    public function getRefinements(): string
    {
        return $this->refinements;
    }

    public function getAdditionalReward(): string
    {
        return $this->additionalReward;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    /** @return Quest[] */
    public function getValidatedQuests(): array
    {
        return $this->validatedQuests;
    }

    /** @return Recipe[] */
    public function getRecipes(): array
    {
        return $this->recipes;
    }
}
