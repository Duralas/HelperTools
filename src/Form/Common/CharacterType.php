<?php

declare(strict_types=1);

namespace App\Form\Common;

use Symfony\Component\Form\{
    AbstractType,
    Extension\Core\Type\TextType
};
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'character_type.label',
            'empty_data' => '',
            'translation_domain' => 'form',
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}
