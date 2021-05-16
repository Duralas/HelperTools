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

class StringArrayChoiceType extends ChoiceType implements DataTransformerInterface
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
        $resolver->setDefault('multiple', true);
        $resolver->setAllowedValues('multiple', true);
    }

    /**
     * @param mixed $value
     * @return string[]
     */
    public function transform($value): ?array
    {
        if ($this->isUnexpectedType($value)) {
            throw new UnexpectedTypeException($value, 'string[]');
        }

        // Model data should not be transformed
        return $value;
    }

    /**
     * @param mixed $value
     * @return string[]
     */
    public function reverseTransform($value): ?array
    {
        return $this->isUnexpectedType($value) ? [] : $value;
    }

    /** @param mixed $value */
    private function isUnexpectedType($value): bool
    {
        $isStringArray = false;
        if (is_array($value)) {
            foreach ($value as $item) {
                $isStringArray = is_string($item);
                if ($isStringArray === false) {
                    break;
                }
            }
        }

        return $isStringArray === false &&
            ($this->isRequired || ($value !== null && (is_array($value) === false || count($value) > 0)));
    }
}
