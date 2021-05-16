<?php

declare(strict_types=1);

namespace App\Form\Common\Typed;

use Symfony\Component\Form\{
    AbstractType,
    Extension\Core\Type\NumberType
};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Type;

class IntType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => new Type('numeric'),
            'html5' => true,
        ]);
    }

    public function getParent(): string
    {
        return NumberType::class;
    }
}
