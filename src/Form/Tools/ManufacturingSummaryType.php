<?php

declare(strict_types=1);

namespace App\Form\Tools;

use App\{
    Form\Common\CharacterType,
    Form\Common\CraftingExperienceType,
    Form\Common\RaceType,
    Form\Common\StringChoiceType,
    Model\Common\Equipment,
    Model\Tools\ManufacturingSummary
};
use Symfony\Component\Form\{
    AbstractType,
    Extension\Core\Type\ChoiceType,
    Extension\Core\Type\NumberType,
    Extension\Core\Type\SubmitType,
    Extension\Core\Type\TextareaType,
    Extension\Core\Type\TextType,
    FormBuilderInterface
};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Formulaire pour l'outil "manufacturing_report" permettant de gérer le rapport des métiers de manufacture.
 */
final class ManufacturingSummaryType extends AbstractType
{
    private DenormalizerInterface $denormalizer;

    private TranslatorInterface $translator;

    /** @var Equipment[] */
    private array $equipments;

    /**
     * @required
     * @return $this
     */
    public function setDenormalizer(DenormalizerInterface $normalizer): self
    {
        $this->denormalizer = $normalizer;

        return $this;
    }

    /**
     * @required
     * @return $this
     */
    public function setTranslator(TranslatorInterface $translator): self
    {
        $this->translator = $translator;

        return $this;
    }

    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * @required
     * @param array<string[]> $equipments
     * @return $this
     */
    public function setEquipments(array $equipments): self
    {
        $equipmentArray = [];
        foreach ($equipments as $equipment) {
            $equipmentArray[] = $this->denormalizer->denormalize($equipment, Equipment::class);
        }
        $this->equipments = $equipmentArray;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $translator = $this->getTranslator();

        $builder
            ->add('character', CharacterType::class)
            ->add('race', RaceType::class)
            ->add('manufacturingLicense', StringChoiceType::class, [
                'label' => 'tools.manufacturing_summary.manufacturing_license.label',
                'choices' => ManufacturingSummary::MANUFACTURING_LICENSES,
                'choice_label' => static fn (string $value) => 'tools.manufacturing_summary.manufacturing_license' .
                    ".choice.{$value}",
            ])
            ->add('craftingExperience', CraftingExperienceType::class)
            ->add('manufacturedEquipments', ChoiceType::class, [
                'label' => 'tools.manufacturing_summary.manufactured_equipments.label',
                'choices' => $this->equipments,
                'choice_label' => static fn (Equipment $equipment) => $equipment->getName(),
//                'choice_value' => static fn (Equipment $equipment) => $equipment->getRegistration(),
//                'group_by' => static fn (Equipment $equipment) => $translator->trans(
//                    'admin.crafting.license.' . $equipment->getManufacturingLicense(),
//                    [],
//                    'rules'
//                ),
                'multiple' => true,
                'required' => false,
            ])
            ->add('enhancedEquipments', ChoiceType::class, [
                'label' => 'tools.manufacturing_summary.enhanced_equipments.label',
                'choices' => $this->equipments,
                'choice_label' => static fn (Equipment $equipment) => $equipment->getName(),
//                'choice_value' => static fn (Equipment $equipment) => $equipment->getRegistration(),
//                'group_by' => static fn (Equipment $equipment) => $translator->trans(
//                    'admin.crafting.license.' . $equipment->getEnhancementLicense(),
//                    [],
//                    'rules'
//                ),
                'multiple' => true,
                'required' => false,
            ])
            ->add('experienceBonus', NumberType::class, [
                'label' => 'tools.manufacturing_summary.experience_bonus.label',
                'empty_data' => null,
                'html5' => true,
                'required' => false,
            ])
            ->add('additionalReward', TextType::class, [
                'label' => 'tools.manufacturing_summary.additional_reward.label',
                'empty_data' => '',
                'required' => false,
            ])
            ->add('manufacturingQuest', ChoiceType::class, [
                'label' => 'tools.manufacturing_summary.manufacturing_quest.label',
                'required' => false,
                'choices' => ManufacturingSummary::MANUFACTURING_QUESTS,
                'choice_label' =>
                    static fn (string $value) => "tools.manufacturing_summary.manufacturing_quest.choice.{$value}",
                'multiple' => true,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'tools.manufacturing_summary.comment.label',
            ])
            ->add('generate', SubmitType::class, [
                'label' => 'tools.manufacturing_summary.generate.label',
            ])
        ;
    }
    
    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ManufacturingSummary::class,
            'translation_domain' => 'form',
        ]);
    }
}
