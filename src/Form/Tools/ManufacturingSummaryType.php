<?php

declare(strict_types=1);

namespace App\Form\Tools;

use App\{
    DBAL\ManufacturingLicenseType,
    Form\Common\AdditionalRewardType,
    Form\Common\CharacterType,
    Form\Common\CommentType,
    Form\Common\CraftingExperienceType,
    Form\Common\EquipmentType,
    Form\Common\GenerateType,
    Form\Common\RaceType,
    Form\Common\Typed\StringArrayChoiceType,
    Form\Common\Typed\StringChoiceType,
    Model\Tools\ManufacturingSummary,
    Repository\EquipmentRepository
};
use Symfony\Component\Form\{
    AbstractType,
    FormBuilderInterface
};
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire pour l'outil "manufacturing_report" permettant de gérer le rapport des métiers de manufacture.
 */
final class ManufacturingSummaryType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('character', CharacterType::class)
            ->add('race', RaceType::class)
            ->add('manufacturingLicense', StringChoiceType::class, [
                'label' => 'Métier de manufacture',
                'choices' => ManufacturingLicenseType::MANUFACTURING_LICENSES,
                'choice_label' => static fn (string $value) => 'tools.manufacturing_summary.manufacturing_license' .
                    ".choice.{$value}",
            ])
            ->add('craftingExperience', CraftingExperienceType::class)
            ->add('manufacturedEquipments', EquipmentType::class, [
                'label' => 'Fabrication(s)',
                'query_builder' => static fn (EquipmentRepository $repo) =>
                    $repo->getManufacturingQb(ManufacturingLicenseType::MANUFACTURING_LICENSES),
                'multiple' => true,
                'required' => false,
            ])
            ->add('enhancedEquipments', EquipmentType::class, [
                'label' => 'Amélioration(s)',
                'query_builder' => static fn (EquipmentRepository $repo) =>
                    $repo->getEnhancingQb(ManufacturingLicenseType::MANUFACTURING_LICENSES),
                'multiple' => true,
                'required' => false,
            ])
            ->add('experienceBonus', CraftingExperienceType::class, [
                'label' => 'Expérience métier bonus',
            ])
            ->add('additionalReward', AdditionalRewardType::class)
            ->add('manufacturingQuest', StringArrayChoiceType::class, [
                'label' => 'Quête(s) réalisée(s)',
                'required' => false,
                'choices' => ManufacturingSummary::MANUFACTURING_QUESTS,
                'choice_label' =>
                    static fn (string $value) => "tools.manufacturing_summary.manufacturing_quest.choice.{$value}",
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
            'data_class' => ManufacturingSummary::class,
        ]);
    }
}
