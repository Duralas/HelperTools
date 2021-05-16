<?php

declare(strict_types=1);

namespace App\Form\Common\Typed;

use Symfony\Component\Form\{
    AbstractType,
    Extension\Core\Type\TextType
};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Type;

class StringType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => new Type('string'),
            'empty_data' => '',
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}
