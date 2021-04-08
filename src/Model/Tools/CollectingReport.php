<?php

declare(strict_types=1);

namespace App\Model\Tools;

use App\Model\Common\Quest;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * Classe modèle contenant les informations du rapport de collecte.
 */
final class CollectingReport
{
    protected string $race = '';
    
    protected string $character = '';
    
    /** @SerializedName("collecting_loots") */
    protected string $collectingLoots;
    
    /** @SerializedName("collecting_experience") */
    protected string $collectingExperience;
    
    /** @SerializedName("additional_reward") */
    protected string $additionalReward;
    
    protected string $comment;

    /**
     * @SerializedName("validated_quests")
     * @var Quest[]
     */
    protected array $validatedQuests;

    /** @param Quest[] $validatedQuests */
    public function __construct(
        string $race,
        string $character,
        string $collectingLoots,
        string $collectingExperience,
        string $additionalReward,
        string $comment,
        array $validatedQuests
    ) {
        $this->race = $race;
        $this->character = $character;
        $this->collectingLoots = $collectingLoots;
        $this->collectingExperience = $collectingExperience;
        $this->additionalReward = $additionalReward;
        $this->comment = $comment;
        $this->validatedQuests = $validatedQuests;
    }

    public function getRace(): string
    {
        return $this->race;
    }

    public function getCharacter(): string
    {
        return $this->character;
    }

    public function getCollectingLoots(): string
    {
        return $this->collectingLoots;
    }

    public function getCollectingExperience(): string
    {
        return $this->collectingExperience;
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
}
