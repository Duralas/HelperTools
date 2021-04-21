<?php

declare(strict_types=1);

namespace App\Form\Common;

use Symfony\Component\Form\{
    AbstractType,
    DataTransformerInterface,
    Exception\UnexpectedTypeException,
    Extension\Core\Type\NumberType,
    FormBuilderInterface
};
use App\Validator\Constraints\CraftingExperience;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CraftingExperienceType extends AbstractType implements DataTransformerInterface
{
    public const EXPERIENCE_BY_RP = 5;
    public const MAX_EXPERIENCE = 200;
    public const MIN_REQUIREMENT_APPRENTICE = 41;
    public const MIN_REQUIREMENT_JOURNEYMAN = 81;
    public const MIN_REQUIREMENT_EXPERT = 121;
    public const MIN_REQUIREMENT_MASTER = 161;
    public const MIN_REQUIREMENT_ABSOLUTE_MASTER = 200;

    public const LICENSE_RANK_APPRENTICE = 'apprentice';
    public const LICENSE_RANK_JOURNEYMAN = 'journeyman';
    public const LICENSE_RANK_EXPERT = 'expert';
    public const LICENSE_RANK_MASTER = 'master';
    public const LICENSE_RANK_ABSOLUTE_MASTER = 'absolute_master';

    private bool $isNullable = false;

    /** @param array<mixed> $options */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // En l'ajoutant maintenant, il sera le dernier DataTransformer utilisé
        $builder->addViewTransformer($this);
        parent::buildForm($builder, $options);

        // Récupération de l'option en tant qu'attribut de class pour les méthodes DataTransformer
        $optIsNullable = $options['is_nullable'];
        if (is_bool($optIsNullable) === false) {
            throw new UnexpectedTypeException($optIsNullable, 'bool');
        }
        $this->isNullable = $optIsNullable;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'label' => 'crafting_experience_type.label',
                'required' => false,
                'attr' => [
                    'min' => 0,
                    'max' => static::MAX_EXPERIENCE,
                ],
                'constraints' => [new CraftingExperience()],
                'html5' => true,
                'translation_domain' => 'form',
            ]
        );

        $resolver
            ->define('is_nullable')
            ->default($this->isNullable)
            ->allowedTypes('bool')
        ;
    }

    public function getParent(): string
    {
        return NumberType::class;
    }

    /** @param mixed $value */
    public function transform($value): ?int
    {
        return $this->getIntValue($value);
    }

    /** @param mixed $value */
    public function reverseTransform($value): ?int
    {
        return $this->getIntValue($value);
    }

    /** @param mixed $value */
    private function getIntValue($value): int
    {
        if (
            is_numeric($value) === false &&
            (
                ($value === null && $this->isNullable === false) ||
                $value !== null
            )
        ) {
            throw new UnexpectedTypeException($value, 'numeric');
        }

        return (int) $value;
    }
}
