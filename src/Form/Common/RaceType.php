<?php

declare(strict_types=1);


namespace App\Form\Common;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Champ de formulaire commun pour les races jouables.
 */
class RaceType extends AbstractType
{
    public const RACE_CHOICES = [
        'abyssal',
        'djollfulin',
        'elf',
        'giant',
        'human',
        'hybrid',
        'naga',
        'dwarf',
        'green_skin',
        'white_stryge',
        'black_stryge',
        'therianthrope',
        'vampire',
    ];

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'race_type.label',
            'choices' => static::RACE_CHOICES,
            'choice_label' => static fn (string $value) => "race_type.choice.{$value}",
            'translation_domain' => 'form',
        ]);
    }

    public function getParent(): string
    {
        return StringChoiceType::class;
    }
}
