<?php

declare(strict_types=1);

namespace App\Form\Tools;

use App\{
    Form\Common\AdditionalRewardType,
    Form\Common\CharacterType,
    Form\Common\CommentType,
    Form\Common\CraftingExperienceType,
    Form\Common\GenerateType,
    Form\Common\RaceType,
    Form\Common\Typed\StringArrayChoiceType,
    Form\Common\Typed\StringChoiceType,
    Model\Tools\CollectingSummary
};
use Symfony\Component\Form\{
    AbstractType,
    FormBuilderInterface
};
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire pour l'outil "collecting_report" permettant de gérer le rapport des métiers de récolte.
 */
final class CollectingSummaryType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('character', CharacterType::class)
            ->add('race', RaceType::class)
            ->add('collectingLicense', StringChoiceType::class, [
                'label' => 'Métier de récolte',
                'choices' => CollectingSummary::COLLECTING_LICENSES,
                'choice_label' => static fn (string $value) => "tools.collecting_summary.collecting_license.choice.{$value}",
            ])
            ->add('craftingExperience', CraftingExperienceType::class)
            ->add('collectingArea', StringChoiceType::class, [
                'label' => 'Zone de récolte',
                'choices' => CollectingSummary::COLLECTING_AREAS,
                'choice_label' => static fn (string $value) => "tools.collecting_summary.collecting_area.choice.{$value}",
            ])
            ->add('additionalReward', AdditionalRewardType::class)
            ->add('collectingQuest', StringArrayChoiceType::class, [
                'label' => 'Quête(s) réalisée(s)',
                'required' => false,
                'choices' => CollectingSummary::COLLECTING_QUESTS,
                'choice_label' => static fn (string $value) => "tools.collecting_summary.collecting_quest.choice.{$value}",
                'multiple' => true,
            ])
            ->add('comment', CommentType::class)
            ->add('generate', GenerateType::class)
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CollectingSummary::class,
        ]);
    }
}
