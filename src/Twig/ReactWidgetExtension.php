<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\Form\{
    ChoiceList\View\ChoiceView,
    FormError,
    FormErrorIterator,
    FormView};
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\{
    Extension\AbstractExtension,
    TwigFilter
};

final class ReactWidgetExtension extends AbstractExtension
{
    private TranslatorInterface $translator;

    /** @required */
    public function setTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;
    }

    /** @return array<mixed> */
    public function getReactWidgetData(FormView $formView, string $widget): array
    {
        return [
            'attr' => $formView->vars['attr'],
            'choices' => $widget === 'choice'
                ? $this->getChoices($formView->vars['choices'], $this->getChoiceTranslationDomain($formView))
                : null,
            'disabled' => $formView->vars['disabled'],
            'error' => array_key_exists('errors', $formView->vars) ? $formView->vars['errors']->count() > 0 : null,
            'helperText' => array_key_exists('errors', $formView->vars)
                ? $this->getHelperText($formView->vars['errors'], $formView->vars['help'])
                : $formView->vars['help'] ?? '',
            'id' => $formView->vars['id'],
            'label' => is_string($formView->vars['translation_domain'])
                ? $this->translator->trans($formView->vars['label'], [], $formView->vars['translation_domain'])
                : $formView->vars['label'],
            'multiline' => $widget === 'textarea',
            'multiple' => $formView->vars['multiple'] ?? false,
            'name' => $formView->vars['full_name'],
            'required' => $formView->vars['required'] ?? null,
            'type' => $formView->vars['type'] ?? 'text',
            'value' => $formView->vars['value'],
        ];
    }

    /** @return array<TwigFilter> */
    public function getFilters(): array
    {
        return [
            new TwigFilter('react_widget', [$this, 'getReactWidgetData']),
        ];
    }

    private function getHelperText(FormErrorIterator $errors, ?string $help): string
    {
        if ($errors->count() === 0) {
            return $help ?? '';
        }

        $errorMessages = [];
        /** @var FormError $error */
        foreach ($errors as $error) {
            $errorMessages[] = $error->getMessage();
        }

        return implode("\n", $errorMessages);
    }

    /**
     * @param array<ChoiceView> $choices
     * @return array<string>
     */
    private function getChoices(array $choices, ?string $translationDomain): array
    {
        $formattedChoices = [];
        if (is_string($translationDomain)) {
            foreach ($choices as $choice) {
                $formattedChoices[$choice->value] = $this->translator->trans($choice->label, [], $translationDomain);
            }
        } else {
            foreach ($choices as $choice) {
                $formattedChoices[$choice->value] = $choice->label;
            }
        }

        return $formattedChoices;
    }

    private function getChoiceTranslationDomain(FormView $formView): ?string
    {
        $translationDomain = $formView->vars['choice_translation_domain'] ?? $formView->vars['translation_domain'];

        return is_string($translationDomain) ? $translationDomain : null;
    }
}
