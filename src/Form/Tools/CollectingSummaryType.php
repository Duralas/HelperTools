<?php

declare(strict_types=1);

namespace App\Form\Tools;

use App\{
    Form\Common\CharacterType,
    Form\Common\LicenseExperienceType,
    Form\Common\RaceType,
    Form\Common\StringChoiceType,
    Model\Tools\CollectingSummary
};
use Symfony\Component\Form\{
    AbstractType,
    Extension\Core\Type\ChoiceType,
    Extension\Core\Type\SubmitType,
    Extension\Core\Type\TextareaType,
    Extension\Core\Type\TextType,
    FormBuilderInterface
};
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire pour l'outil "collecting_report" permettant de gérer le rapport des métiers de récolte.
 */
class CollectingSummaryType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('character', CharacterType::class)
            ->add('race', RaceType::class)
            ->add('collectingLicense', ChoiceType::class, [
                'label' => 'tools.collecting_summary.collecting_license.label',
                'choices' => CollectingSummary::COLLECTING_LICENSES,
                'choice_label' => static fn (string $value) => "tools.collecting_summary.collecting_license.choice.{$value}",
            ])
            ->add('licenseExperience', LicenseExperienceType::class)
            ->add('collectingArea', StringChoiceType::class, [
                'label' => 'tools.collecting_summary.collecting_area.label',
                'choices' => CollectingSummary::COLLECTING_AREAS,
                'choice_label' => static fn (string $value) => "tools.collecting_summary.collecting_area.choice.{$value}",
            ])
            ->add('additionalReward', TextType::class, [
                'label' => 'tools.collecting_summary.additional_reward.label',
                'empty_data' => '',
                'required' => false,
            ])
            ->add('collectingQuest', ChoiceType::class, [
                'label' => 'tools.collecting_summary.collecting_quest.label',
                'required' => false,
                'choices' => CollectingSummary::COLLECTING_QUESTS,
                'choice_label' => static fn (string $value) => "tools.collecting_summary.collecting_quest.choice.{$value}",
                'multiple' => true,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'tools.collecting_summary.comment.label',
            ])
            ->add('generate', SubmitType::class, [
                'label' => 'tools.collecting_summary.generate.label',
            ])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CollectingSummary::class,
            'translation_domain' => 'form',
        ]);
    }
}
