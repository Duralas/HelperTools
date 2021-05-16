<?php

declare(strict_types=1);

namespace App\Form\Common\Typed;

use Symfony\Component\Form\{
    DataTransformerInterface,
    Exception\UnexpectedTypeException,
    Extension\Core\Type\ChoiceType,
    FormBuilderInterface
};
use Symfony\Component\OptionsResolver\OptionsResolver;

class StringChoiceType extends ChoiceType implements DataTransformerInterface
{
    private bool $isRequired = false;

    /** @param array<mixed> $options */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // En l'ajoutant maintenant, il sera le dernier DataTransformer utilisé
        $builder->addViewTransformer($this);
        parent::buildForm($builder, $options);

        // Récupération de l'option en tant qu'attribut de class pour les méthodes DataTransformer
        $optIsRequired = $options['required'];
        if (is_bool($optIsRequired) === false) {
            throw new UnexpectedTypeException($optIsRequired, 'bool');
        }
        $this->isRequired = $optIsRequired;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('choice_translation_domain', 'form');
        $resolver->setAllowedValues('multiple', false);
    }

    /** @param mixed $value */
    public function transform($value): ?string
    {
        if ($this->isUnexpectedType($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        // Model data should not be transformed
        return $value;
    }

    /** @param mixed $value */
    public function reverseTransform($value): ?string
    {
        return $this->isUnexpectedType($value) ? '' : $value;
    }

    /** @param mixed $value */
    private function isUnexpectedType($value): bool
    {
        return is_string($value) === false && ($value !== null || $this->isRequired);
    }
}
