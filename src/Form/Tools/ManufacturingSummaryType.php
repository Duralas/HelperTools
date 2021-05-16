<?php

declare(strict_types=1);

namespace App\Form\Tools;

use App\{
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
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Formulaire pour l'outil "manufacturing_report" permettant de gérer le rapport des métiers de manufacture.
 */
final class ManufacturingSummaryType extends AbstractType
{
    private TranslatorInterface $translator;

    /**
     * @required
     * @return $this
     */
    public function setTranslator(TranslatorInterface $translator): self
    {
        $this->translator = $translator;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $translator = $this->translator;

        $builder
            ->add('character', CharacterType::class)
            ->add('race', RaceType::class)
            ->add('manufacturingLicense', StringChoiceType::class, [
                'label' => 'Métier de manufacture',
                'choices' => ManufacturingSummary::MANUFACTURING_LICENSES,
                'choice_label' => static fn (string $value) => 'tools.manufacturing_summary.manufacturing_license' .
                    ".choice.{$value}",
            ])
            ->add('craftingExperience', CraftingExperienceType::class)
            ->add('manufacturedEquipments', EquipmentType::class, [
                'label' => 'Fabrication(s)',
                'query_builder' => static function (EquipmentRepository $repo) {
                    return $repo
                        ->createQueryBuilder('e')
                        ->where('e.manufacturingLicense in (:licenses)')
                        ->setParameter('licenses', ManufacturingSummary::MANUFACTURING_LICENSES);
                },
//                'group_by' => static fn (Equipment $equipment) => $translator->trans(
//                    'admin.crafting.license.' . $equipment->getManufacturingLicense(),
//                    [],
//                    'rules'
//                ),
                'multiple' => true,
                'required' => false,
            ])
            ->add('enhancedEquipments', EquipmentType::class, [
                'label' => 'Amélioration(s)',
                'query_builder' => static function (EquipmentRepository $repo) {
                    return $repo
                        ->createQueryBuilder('e')
                        ->where('e.enhancementLicense in (:licenses)')
                        ->setParameter('licenses', ManufacturingSummary::MANUFACTURING_LICENSES);
                },
//                'group_by' => static fn (Equipment $equipment) => $translator->trans(
//                    'admin.crafting.license.' . $equipment->getEnhancementLicense(),
//                    [],
//                    'rules'
//                ),
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
